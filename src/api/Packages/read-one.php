<?php
   header("Access-Control-Allow-Orign: *");
   header("Content-Type: application/json; charset=UTF-8");
   
   include_once '../../database/Database.php';
   include_once '../../controllers/PackagesController.php';
   $database = new Database();
   $db = $database->connect();
    
   $controller = new PackageController($db);
   $packageId = isset($_Get['id']) ? $_GET['id'] : 1;
   $stmt = $controller->getPackageWithVideo($packageId);
   $VideoResult = $stmt->get_result();
   $num = mysqli_num_rows($VideoResult);
    if ($num > 0){
        $row = mysqli_fetch_assoc($VideoResult);
        while($row = mysqli_fetch_assoc($VideoResult)) {
            $result = array(
                "Title" => $row['Title'],
                "Path" => $row['FilePath'],
                "Package"=>$row['PackageID'],
                "Questions" => $questions = [],
                
            );
            $package = $row['PackageID'];
            do {
            
            $QuestionObj = [
              "QuestionID" => $row["QuestionID"],
              "QuestionTimestamp" => $row["QuestionTimeStamp"],
              "QuestionText" => $row["QuestionText"],
              "Answer" => $answers = []
              ];
      
              do {
                $AnswerObj = [
                "AnswerID" => $row["ChoiceID"],
                "AnswerText" => $row["ChoiceText"],
                "AnswerOrder" => $row["ChoiceOrder"],
                "Correct" => $row["correct"]
                ];
      
                array_push($QuestionObj['Answer'], $AnswerObj);
      
              } while( $row["ChoiceOrder"] < 4 && $package == $row['PackageID'] &&$row =  mysqli_fetch_assoc($VideoResult));
      
              array_push($result["Questions"], $QuestionObj);
            } while( $package == $row['PackageID'] && $row =  mysqli_fetch_assoc($VideoResult));
          }

        http_response_code(200);
     
        echo json_encode($result);
    }
    else{
        http_response_code(404);
     
        echo json_encode(
            array ("message" => "No Package found for given ID.")
        );
    }
?>