<?php
class QuestionController {
  private $conn;
  private $question;
  private $category;
  private $choice1;
  private $choice2;
  private $choice3;
  private $choice4;
  private $correct;
  private $qtable = 'questions';
  private $ctable = 'choices';
  private $last_id; 
  private $choices;

  public function __construct($db, $question, $category, $choice1, $choice2, $choice3, $choice4, $correct)
  {
    $this->conn = $db;
    $this->question = $question;
    $this->category = $category;
    $this->choice1 = $choice1;
    $this->choice2 = $choice2;
    $this->choice3 = $choice3;
    $this->choice4 = $choice4;
    $this->correct = $correct;
  }

  public function create()
  {
    $this->question = htmlspecialchars(strip_tags($this->question));
    $this->category = htmlspecialchars(strip_tags($this->category));
    $this->choice1 = htmlspecialchars(strip_tags($this->choice1));
    $this->choice2 = htmlspecialchars(strip_tags($this->choice2));
    $this->choice3 = htmlspecialchars(strip_tags($this->choice3));
    $this->choice4 = htmlspecialchars(strip_tags($this->choice4));
    $this->correct = htmlspecialchars(strip_tags($this->correct));


    $this->choices = [$this->choice1 => 1,
                      $this->choice2 => 2,
                      $this->choice3 => 3,
                      $this->choice4 => 4];

    $qquery = "INSERT INTO $this->qtable (QuestionText, Catagory, DateModified) VALUES (?, ?, CURDATE() )";
    
    $query = $this->conn->prepare($qquery);
    if ($query == false) {
      $error = $this->conn->errno . ' ' . $this->conn->error;
      echo $error;
    } else {
      $query->bind_param("ss", $this->question, $this->category);  
      $query->execute();
    }

    $this->last_id = mysqli_insert_id($this->conn);
    
    foreach( $this->choices as $choice => $ord ) {
      if( $ord == $this->correct ) {
        $cquery = "INSERT INTO $this->ctable (QuestionID, ChoiceText, ChoiceOrder, DateModified, correct) " .
                 "VALUES (?, ?, ?, CURDATE(), TRUE )";

      } else {
        $cquery = "INSERT INTO $this->ctable (QuestionID, ChoiceText, ChoiceOrder, DateModified, correct) " .
                 "VALUES (?, ?, ?, CURDATE(), FALSE)";
      }
      
      $query = $this->conn->prepare($cquery);
      if ($query == false) {
        $error = $this->conn->errno . ' ' . $this->conn->error;
        echo $error;
      } else {
        $query->bind_param("isi", $this->last_id, $choice, $ord);  
        $query->execute();
      }
    }
    return true;
    
  }
}


    











  
  



