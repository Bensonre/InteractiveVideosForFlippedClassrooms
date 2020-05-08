<?php
    include_once '../../database/Database.php';
    include_once '../../controllers/PackageController.php';
    include_once '../../controllers/CombineController.php';
    include_once '../../session_variables/session_variables.php';

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    
    $data = json_decode($_POST["data"]);
    $oldPackageId = $data->oldPackageId;
    $newTitle = $data->newTitle;
    $response = array("success" => 0, "message" => "Server Error");
    $databasePackageEntryCreated = false;
    $databaseQuestionEntryCreated = false;
    $GotOldPackage = false;
    $numQuestion = 0;
    $success =0;
    $message = "Server Error";
    

    if($oldPackageId == NULL || $newTitle == NULL || $ivcInstructorId== NULL){
        echo json_encode(array("success" => 0, "message" => "Missing required Data"));
    }
    else{
        $database = new Database();
        $db = $database->connect();
        $controller = new PackageController($db);

        //get video ID of old package for new package creation
        $videoID = $controller->getVideoIdOfPackage($oldPackageId);
        //if failed report failure
        if($videoID == null){
            echo json_encode(array("success" => 0, "message" => "The package video was not found."));
        }
        
        else{ //onsucess create the new package
            if ($controller->create($newTitle, $ivcInstructorId, $videoID)) {
                $databasePackageEntryCreated = true;
            }

            $stmt =  $controller->readPackageIdsbyNewestFromData($newTitle,$ivcInstructorId,$videoID);
            $newPackageId = $stmt->get_result();
            $num = mysqli_num_rows($newPackageId);
            if($num > 0){
                $row = mysqli_fetch_assoc($newPackageId);
                $newPackageId = $row['ID'];
           
                $PackageQuestionController = new CombineController($db);
                $QuestionResult = $PackageQuestionController->getQuestionsInPackage($oldPackageId, $ivcInstructorId);
                $QuestionResult->bind_result($questionID, $text, $timestamp);
                $databaseQuestionEntryCreated = true;
                $Questions = array();
                //grab each questions
                while($QuestionResult->fetch()) {
                    array_push($Questions,array("questionID" => $questionID, "text" => $text ,"timestamp" => $timestamp));
                }
                for($i = 0; $i< count($Questions); $i++) {
                    $value =$PackageQuestionController->create($videoID, $Questions[$i]["questionID"], $newPackageId, $ivcInstructorId, $Questions[$i]["timestamp"]);
                    if(!$value){
                        $success = 0;
                        $message = "The package was duplicated, but There was an error added 1 more questions. Error occured \n Attmepted to add Question to package $newPackageId, with instructor id $ivcInstructorId.";
                        $databaseQuestionEntryCreated = false;
                        break;
                    }
                }
                unset($Question);
            
                if($databasePackageEntryCreated && $databaseQuestionEntryCreated) {
                    $success = 1;
                    $message= "The package was successfully Duplicated.";
                }
            }
            else{
                $message = " no questions founds";
                $success = 0;
            }
            echo json_encode(array("success" => $success, "message" => $message));
        }
    }
?>