<?php

  include_once '../../database/Database.php';
  include_once '../../controllers/QuestionController.php';

  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  $databaseEntryCreated = false;

  $database = new Database();
  $db = $database->connect();

  $controller = new QuestionController($db);

  if(
    !empty($_POST['id']) 
  ){
    $controller->id       = $_POST['id'];

    if ($controller->remove()) {
        $databaseEntryCreated = true;
    } else {
      echo json_encode(array("message" => "Couldn't Delete Question"));
    }
   } else {
      echo json_encode(array("message" => "Can't Delete Question. Insufficient Data."));
   }

   if($databaseEntryCreated == true) {
     echo json_encode(array("message" => "Question Deleted"));
   }

  header("Location: {$_SERVER["HTTP_REFERER"]}");
?>
