<?php
    include_once '../../database/Database.php';
    include_once '../../controllers/VideoController.php';
    include_once '../../session_variables/session_variables.php';

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: multipart/form-data; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $response = array("success" => 0, "message" => "An error occured during upload. Please try again.");

    // Upload the file to the server.
    $targetdir = "../../video_files/";
    $pathdir = "../video_files/";
    $filename = "";
    while (true) {
        $filename = md5(mt_rand());
        if (!file_exists($targetdir . $filename . ".mp4")) { break; }
    }
    $targetfile = $targetdir . $filename . ".mp4";
    $targetpath = $pathdir . $filename . ".mp4";

    $title = $_POST['title'];
    $instructorId = $_POST['instructorId'];

    if (move_uploaded_file($_FILES['local-video-file']['tmp_name'], $targetfile)) {

        // Create a record within the database for this file.
        $database = new Database();
        $db = $database->connect();
        $controller = new VideoController($db);

        if ($controller->create($ivcInstructorId, $_FILES['local-video-file'], $title, $targetpath)) {
            $response["success"] = 1;
            $response["message"] = "Your file was successfully uploaded.";
        }
    }

    echo json_encode($response);
?>
