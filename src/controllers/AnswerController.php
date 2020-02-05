<?php
class AnswerController {

    private $conn;
    private $table = 'studentanswers';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($questionID, $choiceID, $studentID) {
        $questionID = htmlspecialchars(strip_tags($questionID));
        $choiceID = htmlspecialchars(strip_tags($choiceID));
        $studentID = htmlspecialchars(strip_tags($studentID));

        $query = "INSERT INTO $this->table (`QuestionID`, `ChoiceID`, `StudentID`, `AnswerDate`) VALUES (?,?,?,CURDATE())";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            $stmt->bind_param("iii", $questionID, $choiceID, $studentID);
            return $stmt->execute();
        }
        return false;
    }

    public function read($questionID, $studentID) {
        $questionID = htmlspecialchars(strip_tags($questionID));
        $studentID = htmlspecialchars(strip_tags($studentID));

        $query = "SELECT * FROM $this->table WHERE `QuestionID` = ? AND `StudentID` = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            $stmt->bind_param("ii", $questionID, $studentID);
            $stmt->execute();
            return $stmt->fetch_array(MYSQLI_ASSOC);
        }
        return null;
    }

    public function update($questionID, $choiceID, $studentID) {
        $questionID = htmlspecialchars(strip_tags($questionID));
        $choiceID = htmlspecialchars(strip_tags($choiceID));
        $studentID = htmlspecialchars(strip_tags($studentID));

        $query = "UPDATE $this->table SET `ChoiceID` = ?, `AnswerDate` = CURDATE() WHERE `QuestionID` = ? AND `StudentID` = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            $stmt->bind_param("iii", $choiceID, $questionID, $studentID);
            return $stmt->execute();
        }
        return false;
    }

    public function delete($id) {
        $id = htmlspecialchars(strip_tags($id));

        $query = "DELETE FROM $this->table WHERE `ID` = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            $stmt->bind_param("i", $id);
            return $stmt->execute();
        }
        return false;
    }
}
?>