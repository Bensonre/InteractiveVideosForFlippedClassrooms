<?php

  include_once '../../database/Database.php';
  include_once '../../controllers/QuestionController.php';

  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");

  $instructorId = $_GET['instructorId'];

  $databaseEntryCreated = false;
  $results;

  $database = new Database();
  $db = $database->connect();

  $controller = new QuestionController($db);
  if ($results = $controller->read($instructorId)) {
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
        "answer" => $answers = []
        ];

        do {

          $AnswerObj = [
          "answerId" => $aid,
          "answerText" => $ct,
          "answerOrder" => $co,
          "answerModified" => $cm,
          "correct" => $c
          ];

          array_push($QuestionObj['answer'], $AnswerObj);

        } while( $co != 4 && $results->fetch());

        array_push($question_records, $QuestionObj);
    }
    echo json_encode($question_records);
  }
  //header("Location: {$_SERVER["HTTP_REFERER"]}");
?>
