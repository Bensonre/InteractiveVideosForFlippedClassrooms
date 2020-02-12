<?php
class VideoQuestionsController {

    private $conn;
    private $table = 'video_questions';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($videoID, $questionID, $packageID, $timeStamp) {
        $videoID = htmlspecialchars(strip_tags($videoID));
        $questionID = htmlspecialchars(strip_tags($questionID));
        $packageID = htmlspecialchars(strip_tags($packageID));
        $timeStamp = htmlspecialchars(strip_tags($timeStamp));

        $query = "INSERT INTO $this->table (`VideoID`, `QuestionID`, `PackageID`, `QuestionTimeStamp`) VALUES (?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            $stmt->bind_param("iiii", $videoID, $questionID, $packageID, $timeStamp);
            return $stmt->execute();
        }
        return false;
    }
}
?>