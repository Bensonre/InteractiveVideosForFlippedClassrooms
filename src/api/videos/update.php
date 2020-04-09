<?php
    include_once '../../database/Database.php';
    include_once '../../controllers/VideoController.php';

    /**
     * This is the default response in the event that the title of the video is not successfully changed. 
     * Upon success of this condition, this response is updated below.
     */
    $response = array("success" => 0, "message" => "Your title was not successfully uploaded.");

    // Decode posted values.
    $data = json_decode($_POST['data']);
    $id = $data->id;
    $title = $data->title;

    // Database and controller setup.
    $database = new Database();
    $db = $database->connect();
    $controller = new VideoController($db);

    // Update the title of the video.
    if ($controller->update($id, $title)) {
        $response["success"] = 1;
        $response["message"] = "Your title was successfully updated.";
    }

    echo json_encode($response);
?>