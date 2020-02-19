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

  $databaseEntryCreated = false;

  $database = new Database();
  $db = $database->connect();

  $controller = new QuestionController($db);
  $controller->id       = $questionId;

  if ($controller->delete()) {
      $databaseEntryCreated = true;
  } 

  $response = array("success" => 0, "message" => "The question was not successfully deleted.");

  if($databaseEntryCreated == true) {
      $response['success'] = 1;
      $response['message'] = "The question was successfully deleted.";
  }

  echo json_encode($response);
?>
