<?php
class QuestionController {
  private $conn;
  private $qtable = 'questions';
  private $ctable = 'choices';

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
  public function create($question, $category, $choice1, $choice2, $choice3, $choice4, $correct)
  {
    $question = htmlspecialchars(strip_tags($question));
    $category = htmlspecialchars(strip_tags($category));
    $choice1 = htmlspecialchars(strip_tags($choice1));
    $choice2 = htmlspecialchars(strip_tags($choice2));
    $choice3 = htmlspecialchars(strip_tags($choice3));
    $choice4 = htmlspecialchars(strip_tags($choice4));
    $correct = htmlspecialchars(strip_tags($correct));

    $createSuccess = True;

    //maps choices to their positions entered into the form
    $choices = [$choice1 => 1,
                $choice2 => 2,
                $choice3 => 3,
                $choice4 => 4];

    $qquery = "INSERT INTO $this->qtable (QuestionText, Catagory, DateModified) VALUES ('$question', '$category', CURDATE() )";

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

  public function read()
  {
    $query = "SELECT " . $this->qtable . ".ID as QuestionID, QuestionText, Category, " . $this->qtable . ".DateModified as QuestionModified, " . 
             $this->ctable . ".ID as AnswerID, ChoiceText, ChoiceOrder, " . $this->ctable . ".DateModified as ChoiceModified, correct FROM " . $this->qtable . " INNER JOIN " . 
             $this->ctable . " on " . $this->qtable . ".ID=" . $this->ctable . ".QuestionID";
    $result = $this->sendQuery($query);
    $result->store_result();
    return $result;





















  }

  public function update($id, $question, $category, $c1, $c2, $c3, $c4, $correct)
  {
    $id= htmlspecialchars(strip_tags($id));
    $question = htmlspecialchars(strip_tags($question));
    $category = htmlspecialchars(strip_tags($category));
    $c1      = htmlspecialchars(strip_tags($c1));
    $c2      = htmlspecialchars(strip_tags($c2));
    $c3      = htmlspecialchars(strip_tags($c3));
    $c4      = htmlspecialchars(strip_tags($c4));
    $correct = htmlspecialchars(strip_tags($correct));

    $updateSuccess = True;

    $choices = [$c1 => 1,
                $c2 => 2,
                $c3 => 3,
                $c4 => 4];

    $qquery = "UPDATE $this->qtable SET QuestionText='$question', Catagory='$category', DateModified=CURDATE() WHERE ID=$id"; 

    if($this->sendQuery($qquery) == False) {
      $updateSuccess = False;
    }

    foreach($choices as $choice => $ord) {
      //breaks loop if a query failed
      if( $updateSuccess == False ) {
        break;
      }

      if( $ord == $correct ) {
        $cquery = "UPDATE $this->ctable SET ChoiceText='$choice', correct=True, DateModified=CURDATE() WHERE QuestionID=$id AND ChoiceOrder=$ord";
      } else {
        $cquery = "UPDATE $this->ctable SET ChoiceText='$choice', correct=False, DateModified=CURDATE()  WHERE QuestionID=$id AND ChoiceOrder=$ord";
      }

      if($this->sendQuery($cquery) == False) {
        $updateSuccess= False;
      }
    }
    return $updateSuccess;
  }
}



