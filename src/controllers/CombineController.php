<?php
class CombineController {

    private $conn;
    private $table = 'package_questions';
    private $questionTable = 'questions';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($videoID, $questionID, $packageID, $instructorID, $timestamp) {
        $videoID = htmlspecialchars(strip_tags($videoID));
        $questionID = htmlspecialchars(strip_tags($questionID));
        $packageID = htmlspecialchars(strip_tags($packageID));
        $instructorID = htmlspecialchars(strip_tags($instructorID));
        $timestamp = htmlspecialchars(strip_tags($timestamp));

        //$query = "INSERT INTO $this->table (`VideoID`, `QuestionID`, `PackageID`, `InstructorID`, `QuestionTimeStamp`) VALUES (?,?,?,?,?)";
        $query = "INSERT INTO $this->table (`QuestionID`, `PackageID`, `InstructorID`, `QuestionTimeStamp`) VALUES (?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            //$stmt->bind_param("iiiid", $videoID, $questionID, $packageID, $instructorID, $timestamp);
            $stmt->bind_param("iiid", $questionID, $packageID, $instructorID, $timestamp);
            if($stmt->execute() && $this->conn->affected_rows > 0){
                return $this->conn->affected_rows;
            }
        }
        return false;
    }

    public function delete($id) {
        $id = htmlspecialchars(strip_tags($id));

        $query = "DELETE FROM $this->table WHERE `ID` = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            return false;
        } else {
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
        return false;
    }

    public function update($id, $timestamp) {
        $id = htmlspecialchars(strip_tags($id));
        $timestamp = htmlspecialchars(strip_tags($timestamp));

        $query = "UPDATE $this->table SET `QuestionTimeStamp` = ? WHERE `ID` = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            return false;
        } else {
            $stmt->bind_param("di", $timestamp, $id);
            return $stmt->execute();
        }
        return false;
    }

    public function getQuestionsInPackage($packageID, $instructorID) {
        $packageID = htmlspecialchars(strip_tags($packageID));
        $instructorID = htmlspecialchars(strip_tags($instructorID));

        $query = "SELECT b.ID, b.QuestionText, a.QuestionTimeStamp FROM $this->table a, $this->questionTable b WHERE `PackageID` = ? AND a.InstructorID = ? AND b.ID = a.QuestionID";
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
