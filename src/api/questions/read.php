<?php

  include_once '../../database/Database.php';
  include_once '../../controllers/QuestionController.php';

  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  $databaseEntryCreated = false;
  $results;

  $database = new Database();
  $db = $database->connect();

  $controller = new QuestionController($db);
  if ($results = $controller->read()) {
      $databaseRead = true;
  } else {
      echo "\nQuestion Read Failed\n";
  }


  if($results->num_rows() > 0) {
    $question_records = [];
    $results->bind_result($qid, $qt, $cat, $qm, $aid, $ct, $co, $cm, $c);


    while($results->fetch()) {

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

        array_push($question_records, $QuestionObj);
    }
    echo json_encode($question_records);
  }

  //echo "\nredirecting...\n";
  /*header("Location: {$_SERVER["HTTP_REFERER"]}");*/
?>