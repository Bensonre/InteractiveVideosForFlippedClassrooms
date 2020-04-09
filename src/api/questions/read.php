<?php

  include_once '../../database/Database.php';
  include_once '../../controllers/QuestionController.php';
  include_once '../../session_variables/session_variables.php';

  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");

  $databaseEntryCreated = false;
  $results;

  $database = new Database();
  $db = $database->connect();

  $controller = new QuestionController($db);
  if ($results = $controller->read($ivcInstructorId)) {
      $databaseRead = true;
  } else {
      echo "\nQuestion Read Failed\n";
  }


  if($results->num_rows() > 0) {
    $question_records = [];
    $results->bind_result($qid, $qt, $cat, $qm, $aid, $ct, $co, $cm, $c);


    while($results->fetch()) {

      $QuestionObj = [
        "questionId" => $qid,
        "questionText" => $qt,
        "category" => $cat,
        "questionModified" => $qm,
        "answers" => $answers = []
        ];

        do {

          $AnswerObj = [
          "answerId" => $aid,
          "answerText" => $ct,
          "answerOrder" => $co,
          "answerModified" => $cm,
          "correct" => $c
          ];

          array_push($QuestionObj['answers'], $AnswerObj);

        } while( $co != 4 && $results->fetch());

        array_push($question_records, $QuestionObj);
    }
    echo json_encode($question_records);
  }
  //header("Location: {$_SERVER["HTTP_REFERER"]}");
?>
