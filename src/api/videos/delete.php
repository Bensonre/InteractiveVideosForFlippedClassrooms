<?php
    include_once '../../database/Database.php';
    include_once '../../controllers/VideoController.php';

    /**
     * This is the default response in the event that the file is not successfully removed from the server
     * or the database entry cannot be deleted. Upon success of both conditions, this response is updated below.
     */
    $response = array("success" => 0, "message" => "Your video was not successfully deleted.");

    // Decode posted values.
    $data = json_decode($_POST['data']);
    $id = $data->id;
    $file = "../../" . $data->filePath;

    /**
     * Removes the file from the 'video_files' folder then removes the database entry for the video.
     */
    if (unlink($file)) {
        // Database and controller setup.
        $database = new Database();
        $db = $database->connect();
        $controller = new VideoController($db);

        // Remove the database entry.
        if ($controller->delete($id)) {
            $response["success"] = 1;
            $response["message"] = "Your video was successfully deleted.";
        }
    } 

    echo json_encode($response);
?>