<?php

  include_once '../../database/Database.php';
  include_once '../../controllers/QuestionController.php';

  header("Access-Control-Allow-Origin: *");
  header("Access-Control-Allow-headers: access");
  header("Access-Control-Allow-Methods: GET");
  header("Access-Control-Allow-Credentials: true");
  header('Content-Type: application/json');

  $databaseReadSuccesful = false;

  $database = new Database();
  $db = $database->connect();

  $controller = new QuestionController($db);

  if(
    !empty($_GET['id']) 
  ){
    $controller->id = $_GET['id'];

    if ($results = $controller->read_one()) {

      if($results->num_rows() > 0) {
        $question_records = [];
        $results->bind_result($qid, $qt, $cat, $qm, $aid, $ct, $co, $cm, $c);


        $results->fetch(); 

        $QuestionObj = [
          "Question ID" => $qid,
          "Question Text" => $qt,
          "Category" => $cat,
          "Question Modified" => $qm,
          "Answer" => $answers = []
          ];

        do {

          $AnswerObj = [
          "Answer ID" => $aid,
          "Answer Text" => $ct,
          "Answer Order" => $co,
          "Answer Modified" => $cm,
          "Correct?" => $c
          ];

          array_push($QuestionObj['Answer'], $AnswerObj);

        } while( $co != 4 && $results->fetch());
        echo json_encode($QuestionObj);
      } else {
        echo json_encode(array("message" => "There are no records matching that ID"));
      }

      } else {
        echo json_encode(array("message" => "Couldn't Delete Question"));
    }
   } else {
      echo json_encode(array("message" => "Can't Delete Question. Insufficient Data."));
   }

   if($databaseReadSuccesful == true) {
   }

  //header("Location: {$_SERVER["HTTP_REFERER"]}");
?>
