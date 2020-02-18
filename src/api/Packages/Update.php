<?php

include_once '../../database/Database.php';
include_once '../../controllers/PackagesController.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

   $database = new Database();
   $db = $database->connect();
    
   $controller = new PackageController($db);

    $success = false;
    if(isset($_POST[`ID`]) && isset($_POST['Title']) && isset('VideoID')){
            $result = $controller->update($_POST[`ID`],$_POST['Title'], $_POST('VideoID'), date(DATE_RSS));
        if ($result) {
            $success = true;
        }
    }
    echo json_encode($success);
?>
