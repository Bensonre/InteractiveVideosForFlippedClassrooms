<?php
    include_once '../../database/Database.php';
    include_once '../../controllers/VideoController.php';

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: multipart/form-data; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $response = array("success" => 0, "message" => "Your file was not successfully uploaded.");

    // Upload the file to the server.
    $targetdir = "../../video_files/";
    $pathdir = "../video_files/";
    $targetfile = $targetdir . basename($_FILES['local-video-file']['name']);
    $targetpath = $pathdir . basename($_FILES['local-video-file']['name']);

    $title = $_POST['title'];
    $instructorId = $_POST['instructorId'];

    if (!file_exists($targetfile)) {
        if (move_uploaded_file($_FILES['local-video-file']['tmp_name'], $targetfile)) {
            // Create a record within the database for this file.
            $database = new Database();
            $db = $database->connect();
            $controller = new VideoController($db);

            if ($controller->create($instructorId, $_FILES['local-video-file'], $title, $targetpath)) {
                $response["success"] = 1;
                $response["message"] = "Your file was successfully uploaded.";
            }
        }
    } else {
        $response['message'] = "A file with that name already exists on this server. Please change the file's name.";
    }

    echo json_encode($response);
?>
