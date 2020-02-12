<?php

  include_once '../../database/Database.php';
  include_once '../../controllers/PackageController.php';

  header("Access-Control-Allow-Origin: *");
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Methods: POST");
  header("Access-Control-Max-Age: 3600");
  header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

  $databaseEntryCreated = false;

  $database = new Database();
  $db = $database->connect();

  $controller = new PackageController($db);

  if(
    !empty($_POST['id']) 
  ){
    $id= $_POST['id'];

    if ($controller->delete($id)) {
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
