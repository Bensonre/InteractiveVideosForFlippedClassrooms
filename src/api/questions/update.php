<?php

  include_once '../../database/Database.php';
  include_once '../../controllers/QuestionController.php';

  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  $data = json_decode($_POST['data']);
  $questionId = $data->questionId;
  $question = $data->question;
  $category = $data->category;
  $a1 = $data->a1;
  $a2 = $data->a2;
  $a3 = $data->a3;
  $a4 = $data->a4;
  $correct = $data->correct;

  $databaseEntryCreated = false;

  $database = new Database();
  $db = $database->connect();

  $controller = new QuestionController($db);

  $controller->id       = $questionId;
  $controller->question = $question;
  $controller->category = $category;
  $controller->c1       = $a1;
  $controller->c2       = $a2;
  $controller->c3       = $a3;
  $controller->c4       = $a4;
  $controller->correct  = $correct;

  if ($controller->update()) {
      $databaseEntryCreated = True;
  }

  $response = array("success" => 0, "message" => "The question was not successfully updated.");

  if($databaseEntryCreated == True) {
      $response['success'] = 1;
      $response['message'] = "The question was successfully updated.";
  }

  echo json_encode($response);
?>
