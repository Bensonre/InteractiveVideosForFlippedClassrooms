<?php
class VideoQuestionsController {

    private $conn;
    private $table = 'video_questions';
    private $questionTable = 'questions';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($videoID, $questionID, $packageID, $instructorID, $timeStamp) {
        $videoID = htmlspecialchars(strip_tags($videoID));
        $questionID = htmlspecialchars(strip_tags($questionID));
        $packageID = htmlspecialchars(strip_tags($packageID));
        $instructorID = htmlspecialchars(strip_tags($instructorID));
        $timeStamp = htmlspecialchars(strip_tags($timeStamp));

        $query = "INSERT INTO $this->table (`VideoID`, `QuestionID`, `PackageID`, `InstructorID`, `QuestionTimeStamp`) VALUES (?,?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            $stmt->bind_param("iiiii", $videoID, $questionID, $packageID, $instructorID, $timeStamp);
            return $stmt->execute();
        }
        return false;
    }

    public function getQuestionsInPackage($packageID, $instructorID) {
        $packageID = htmlspecialchars(strip_tags($packageID));
        $instructorID = htmlspecialchars(strip_tags($instructorID));

        $query = "SELECT a.ID, b.QuestionText, a.QuestionTimeStamp FROM $this->table a, $this->questionTable b WHERE `PackageID` = ? AND `InstructorID` = ? AND b.ID = a.QuestionID";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            $stmt->bind_param("ii", $packageID, $instructorID);
            $stmt->execute();
            return $stmt;
        }
        return null;
    }
}
?>