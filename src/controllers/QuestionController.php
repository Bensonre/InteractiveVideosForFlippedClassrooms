  <?php
	  $currentpage = "Instructor";
	?>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Flipped Classroom</title>
	  <link rel="stylesheet" href="../css/Site-Style.css"> 
	</head>
	<body>

	<?php
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
	?>
	</body>
</html>
