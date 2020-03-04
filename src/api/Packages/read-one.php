<?php
    header("Access-Control-Allow-Orign: *");
    header("Content-Type: application/json; charset=UTF-8");
    
    include_once '../../database/Database.php';
    include_once '../../controllers/PackagesController.php';
    $database = new Database();
    $db = $database->connect();
      
    $controller = new PackageController($db);
    if (empty($_GET["id"])){
      http_response_code(404);
        
      echo json_encode(
          array ("message" => "No Package ID given")
      );
    } else {

      $packageId = intval($_GET['id']);
      $res = $controller->getPackageWithVideo($packageId);

      echo json_encode($res);
    }
?>