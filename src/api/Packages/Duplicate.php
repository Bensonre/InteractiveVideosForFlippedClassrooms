<?php
    include_once '../../database/Database.php';
    include_once '../../controllers/PackagesController.php';

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $data = json_decode($_POST['data']);
    $oldPackageId = $data->oldPackageId;
    $newTitle = $data->newTitle;
    $instructorId = $data->instructorId;

    $databasePackageEntryCreated = false;
    $databaseQuestionEntryCreated = false;
    $GotOldPackage = false; 


    $database = new Database();
    $db = $database->connect();
    $response = (array("success" => 0, "message" => "Server Error"));
    $controller = new PackageController($db);
    //get video ID of old package for new package creation
    $stmt = $controller->getVideoIdOfPackage($oldPackageId);
    $videoID = $stmt->get_result();
    //if failed report failure
    if($videoID = null){
        echo json_encode(array("success" => 0, "message" => "The package video was not found."));
    }
    else{ //onsucess create the new package

        if ($controller->create($newTitle, $instructorId, $videoID)) {
            $databasePackageEntryCreated = true;
        }

        $stmt =  $controller->readPackagesIdsbyNewestFromData($newTitle,$instructorId,$videoID);
        $newPackageId = $stmt->get_result();
        $num = mysqli_num_rows($videoID);
        if($num > 0){
            $row = mysqli_fetch_assoc($newPackageId);
            $newPackageId = $row['ID'];

            $VQcontroller = new VideoQuestionsController($db);
            $QuestionResult = $VQcontroller->getQuestionsInPackage($oldPackageID, $instructorID);

            $QuestionResult->bind_result($questionID, $text, $timestamp);
            while($result->fetch()) {
                if ($VQuestionsController->create($videoID, $questionID, $newPackageId, $instructorID, $timestamp)) {
                    $databaseQuestionEntryCreated = true;
                }
                else{
                    $databaseQuestionEntryCreated = false;
                    break;
                }
            }
            if(!$databaseQuestionEntryCreated){
                $response = (array("success" => 0, "message" => "The package was created, but there was an error adding questions to it."));
            }
            }
            else{
                $response = array("success" => 0, "message" => "The package was created, but the questions failed to be added.");
            }
    
        if($databasePackageEntryCreated && $databaseQuestionEntryCreated) {
            $response['success'] = 1;
            $response['message'] = "The package was successfully Duplicated.";
        }
        echo json_encode($response);
    }
?>