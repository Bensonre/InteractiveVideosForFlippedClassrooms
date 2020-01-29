  <!--
<html>
	<head>
		<meta charset="UTF-8">
		<title>Flipped Classroom</title>
	  <link rel="stylesheet" href="../css/Site-Style.css"> 
	</head>
	<body>

	<?php
  /*
		include "../includes/header.php";

		$question = $_POST['question'];
		$category = $_POST['category'];
		$c1       = $_POST['a1'];
		$c2       = $_POST['a2'];
		$c3       = $_POST['a3'];
		$c4       = $_POST['a4'];
		$correct  = $_POST['correct'];

		$choices = [$c1 => 1, 
								$c2 => 2, 
								$c3 => 3, 
								$c4 => 4];

		include "../includes/connectvars.php";

	  $date = mysqli_query($mysqli, "SELECT CURDATE()")
		or die('Error Querying the Database');
		
		//Insert values into questions table
		$qquery = "INSERT INTO questions (QuestionText, Catagory, DateModified) " .
						 "VALUES ('$question', '$category', CURDATE() )";

		if(mysqli_query($mysqli, $qquery)) {
			$last_id = mysqli_insert_id($mysqli);
		}else{
			die('Error Querying the Database');
		}


		foreach( $choices as $choice => $ord ) {
			if( $ord == $correct ) {
				$cquery = "INSERT INTO choices (QuestionID, ChoiceText, ChoiceOrder, DateModified, correct) " .
								 "VALUES ('$last_id', '$choice', '$ord', CURDATE(), TRUE )";
				mysqli_query($mysqli, $cquery)
				or die('Error Querying the Database');
			} else {
				$cquery = "INSERT INTO choices (QuestionID, ChoiceText, ChoiceOrder, DateModified, correct) " .
								 "VALUES ('$last_id', '$choice', '$ord', CURDATE(), FALSE )";
				mysqli_query($mysqli, $cquery)
				or die('Error Querying the Database');
			}
		}

		mysqli_close($mysqli);
		


		echo "<p>Success! Your question has been added.</p>";
		echo "<p>Question: $question</p>";
		echo "<p>Category: $category</p>";
		echo "<p>Choice 1: $c1</p>";
		echo "<p>Choice 2: $c2</p>";
		echo "<p>Choice 3: $c3</p>";
		echo "<p>Choice 4: $c4</p>";
    */
	?>
	</body>
</html>
*/
-->


<?php
class CreateQuestionController {
  private $conn;
  private $question;
  private $category;
  private $choice1;
  private $choice2;
  private $choice3;
  private $choice4;
  private $correct;
  private $qtable = 'question';
  private $ctable = 'choices';

  private function InsertHelper($q)
  {
    $query = $this->conn->prepare($q);
    if ($query == false) {
      $error = $this->conn->errno . ' ' . $this->conn->error;
      echo $error;
    } else {
      return $query->execute();
    }
  }


  public function __construct($db, $category, $question, $choice1, $choice2, $choice3, $choice4, $correct)
  {
    $this->conn = $db;
    $this->quesiton = $question;
    $this->category = $category;
    $this->choice1 = $choice1;
    $this->choice2 = $choice2;
    $this->choice3 = $choice3;
    $this->choice4 = $choice4;
  }

  public function create()
  {
    $this->question = htmlspecialchars(strip_tags($this->instructorId));
    $this->category = htmlspecialchars(strip_tags($this->category));
    $this->choice1 = htmlspecialchars(strip_tags($this->choice1);
    $this->choice2 = htmlspecialchars(strip_tags($this->choice2);
    $this->choice3 = htmlspecialchars(strip_tags($this->choice3);
    $this->choice4 = htmlspecialchars(strip_tags($this->choice4);
    $this->correct = htmlspecialchars(strip_tags($this->correct);

    $choices = [$this->choice1 => 1,
                $this->chioce2 => 2,
                $this->chioce3 => 3,
                $this->chioce4 => 4]

		$qquery = "INSERT INTO $this->qtable (QuestionText, Catagory, DateModified) VALUE ('$this->question', '$this->category',CURDATE() )";
    
    InsertHelper($qquery);

    $last_id = mysqli_insert_id($this->conn);
    
		foreach( $choices as $choice => $ord ) {
			if( $ord == $this->correct ) {
				$cquery = "INSERT INTO choices (QuestionID, ChoiceText, ChoiceOrder, DateModified, correct) " .
								 "VALUES ('$last_id', '$choice', '$ord', CURDATE(), TRUE )";

			} else {
				$cquery = "INSERT INTO choices (QuestionID, ChoiceText, ChoiceOrder, DateModified, correct) " .
								 "VALUES ('$last_id', '$choice', '$ord', CURDATE(), FALSE)";
			}
        InsertHelper($cquery);
		}
    
  }
}


    











  
  



