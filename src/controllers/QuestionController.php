<?php
class QuestionController {
  private $conn;
  private $qtable = 'questions';
  private $ctable = 'choices';

  public $id;
  public $question;
  public $category;
  public $a1;
  public $a2;
  public $a3;
  public $a4;
  public $correct;

  private function sendQuery($q) {
      $query = $this->conn->prepare($q);
      if ($query == false) {
        $error = $this->conn->errno . ' ' . $this->conn->error;
        echo $error;
        return False;
      } else {
        $query->execute();
        return $query;
      }
  }

  public function __construct($db)
  {
    $this->conn = $db;
  }
  
  //Creates question. All inputs are expected not to be NULL.
  public function create($question, $category, $c1, $c2, $c3, $c4, $correct, $instructorId) 
  {
    $question = mysqli_real_escape_string($this->conn, htmlspecialchars(strip_tags($question)));
    $category = mysqli_real_escape_string($this->conn, htmlspecialchars(strip_tags($category)));
    $c1       = mysqli_real_escape_string($this->conn, htmlspecialchars(strip_tags($c1)));
    $c2       = mysqli_real_escape_string($this->conn, htmlspecialchars(strip_tags($c2)));
    $c3       = mysqli_real_escape_string($this->conn, htmlspecialchars(strip_tags($c3)));
    $c4       = mysqli_real_escape_string($this->conn, htmlspecialchars(strip_tags($c4)));
    $correct = htmlspecialchars(strip_tags($correct));
    $instructorId = htmlspecialchars(strip_tags($instructorId));

    $createSuccess = True;

    //maps choices to their positions entered into the form
    $choices = [$c1 => 1,
                $c2 => 2,
                $c3 => 3,
                $c4 => 4];

    $qquery = "INSERT INTO $this->qtable (QuestionText, Category, DateModified, InstructorID) VALUES ('$question', '$category', CURDATE(), '$instructorId' )";

    $createSuccess = $this->sendQuery($qquery);

    $last_id = mysqli_insert_id($this->conn);
    
    foreach( $choices as $choice => $ord ) {
      //If a query has failed, end execution and return false
      if( $createSuccess == False ) {
        break;
      }

      if( $ord == $correct ) {
        $cquery = "INSERT INTO $this->ctable (QuestionID, ChoiceText, ChoiceOrder, DateModified, correct) " .
                 "VALUES ('$last_id', '$choice', '$ord', CURDATE(), TRUE )";

      } else {
        $cquery = "INSERT INTO $this->ctable (QuestionID, ChoiceText, ChoiceOrder, DateModified, correct) " .
                 "VALUES ('$last_id', '$choice', '$ord', CURDATE(), FALSE)";
      }
      $createSuccess = $this->sendQuery($cquery);
    }

    return $createSuccess;
  }

  public function read($instructorId)
  {
    $instructorId = htmlspecialchars(strip_tags($instructorId));

    $query = "SELECT " . $this->qtable . ".ID as QuestionID, QuestionText, Category, " . $this->qtable . ".DateModified as QuestionModified, " . 
             $this->ctable . ".ID as AnswerID, ChoiceText, ChoiceOrder, " . $this->ctable . ".DateModified as ChoiceModified, correct FROM " . $this->qtable . " INNER JOIN " . 
             $this->ctable . " on " . $this->qtable . ".ID=" . $this->ctable . ".QuestionID" . " WHERE `InstructorID` = $instructorId";
    $result = $this->sendQuery($query);
    $result->store_result();
    return $result;
  }
  public function read_one() {

    $query = "SELECT " . $this->qtable . ".ID as QuestionID, QuestionText, Category, " . $this->qtable . ".DateModified as QuestionModified, " . 
             $this->ctable . ".ID as AnswerID, ChoiceText, ChoiceOrder, " . $this->ctable . ".DateModified as ChoiceModified, correct FROM " . $this->qtable . " INNER JOIN " . 
             $this->ctable . " on " . $this->qtable . ".ID=" . $this->ctable . ".QuestionID WHERE " . $this->qtable . ".ID=" . $this->id;
    $result = $this->sendQuery($query);
    $result->store_result();
    return $result;
  }

  public function update()
  {
    $this->id= mysqli_real_escape_string($this->conn, htmlspecialchars(strip_tags($this->id)));
    $this->question = mysqli_real_escape_string($this->conn, htmlspecialchars(strip_tags($this->question)));
    $this->category = mysqli_real_escape_string($this->conn, htmlspecialchars(strip_tags($this->category)));
    $this->c1      = mysqli_real_escape_string($this->conn, htmlspecialchars(strip_tags($this->c1)));
    $this->c2      = mysqli_real_escape_string($this->conn, htmlspecialchars(strip_tags($this->c2)));
    $this->c3      = mysqli_real_escape_string($this->conn, htmlspecialchars(strip_tags($this->c3)));
    $this->c4      = mysqli_real_escape_string($this->conn, htmlspecialchars(strip_tags($this->c4)));
    $this->correct = mysqli_real_escape_string($this->conn, htmlspecialchars(strip_tags($this->correct)));

    $updateSuccess = True;

    $choices = [$this->c1 => 1,
                $this->c2 => 2,
                $this->c3 => 3,
                $this->c4 => 4];

    $qquery = "UPDATE $this->qtable SET QuestionText='$this->question', Category='$this->category', DateModified=CURDATE() WHERE ID=$this->id"; 

    if($this->sendQuery($qquery) == False) {
      $updateSuccess = False;
    }

    foreach($choices as $choice => $ord) {
      //breaks loop if a query failed
      if( $updateSuccess == False ) {
        break;
      }

      if( $ord == $this->correct ) {
        $cquery = "UPDATE $this->ctable SET ChoiceText='$choice', correct=True, DateModified=CURDATE() WHERE QuestionID=$this->id AND ChoiceOrder=$ord";
      } else {
        $cquery = "UPDATE $this->ctable SET ChoiceText='$choice', correct=False, DateModified=CURDATE()  WHERE QuestionID=$this->id AND ChoiceOrder=$ord";
      }

      if($this->sendQuery($cquery) == False) {
        $updateSuccess= False;
      }
    }
    return $updateSuccess;
  }

  public function delete()
  {
    $this->id= htmlspecialchars(strip_tags($this->id));

    $deleteSuccess = True;

    $query = "DELETE FROM " . $this->qtable . " WHERE ID=" . $this->id ;
    
    //delete question
    if($this->sendQuery($query) == False) {
      $deleteSuccess = False;
    }

    $query = "DELETE FROM " . $this->ctable . " WHERE QuestionID=" . $this->id ;

    //delete answers
    if($this->sendQuery($query) == False) {
      $deleteSuccess = False;
    }

    return $deleteSuccess;
  
  }
}

?>



