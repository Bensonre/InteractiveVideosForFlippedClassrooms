<?php
    include_once '../../database/Database.php';
    include_once '../../controllers/VideoController.php';

    /*
     * This is the default response in the event that the file is not successfully removed from the server
     * or the database entry cannot be deleted. Upon success of both conditions, this response is updated below.
     */
    $response = array("success" => 0, "message" => "Your video was not successfully deleted.");

    // Decode posted values.
    $data = json_decode($_POST['data']);
    $id = $data->id;
    $file = "../../" . $data->filePath;

    /*
     * Check if this file exists within the 'video_files' folder. The current video being requested for deletion
     * could be a YouTube video and not have an associated file in 'video_files'.
     */
    $isLocal = false;
    if (file_exists($file)) {
        $isLocal = true;
    }

    // If this is a locally stored video, remove the file from the 'video_files' folder.
    if ($isLocal) {
        unlink($file);
    }

    // Lastly, remove the database entry for the video.
    $database = new Database();
    $db = $database->connect();
    $controller = new VideoController($db);
    if ($controller->delete($id)) {
        $response["success"] = 1;
        $response["message"] = "Your video was successfully deleted.";
    }

    echo json_encode($response);
?>