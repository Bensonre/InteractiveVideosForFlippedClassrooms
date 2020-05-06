<?php
    include_once '../../database/Database.php';
    include_once '../../controllers/VideoController.php';
    include_once '../../session_variables/session_variables.php';

    /*
     * This is the default response in the event that the file is not successfully uploaded to the server
     * or the database entry cannot be created. Upon success of both conditions, this response is updated below.
     */
    $response = array("success" => 0, "message" => "An error occured during upload. Please try again.");

    // Database and controller setup.
    $database = new Database();
    $db = $database->connect();
    $controller = new VideoController($db);

    /*
     * Determine if a video file or unlisted YouTube link was provided and act accordingly.
     */
    if ($_POST['link']) {
        // Create the database entry.
        if ($controller->createURL($ivcInstructorId, $_POST['title'], $_POST['link'])) {
            $response["success"] = 1;
            $response["message"] = "Your file was successfully uploaded.";
        }
    } else {
        // Create a hash value for the filename and determine the file path.
        $targetDirectory = "../../video_files/";
        $pathDirectory = "video_files/";
        $filename = "";
        while (true) {
            $filename = md5(mt_rand());
            if (!file_exists($targetDirectory . $filename . ".mp4")) { break; }
        }
        $targetFile = $targetDirectory . $filename . ".mp4";
        $databasePath = $pathDirectory . $filename . ".mp4";

        /*
         * Moves the file into the 'video_files' folder then creates a database entry for the video.
         */
        if (move_uploaded_file($_FILES['local-video-file']['tmp_name'], $targetFile)) {
            // Create the database entry.
            if ($controller->create($ivcInstructorId, $_FILES['local-video-file'], $_POST['title'], $databasePath)) {
                $response["success"] = 1;
                $response["message"] = "Your file was successfully uploaded.";
            } else {
                // The database entry could not be created, so the file needs to be deleted from the server.
                unlink($targetFile);
            }
        }
    }

    echo json_encode($response);
?>
