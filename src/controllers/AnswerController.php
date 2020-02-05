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

    }

    public function update($questionID, $studentID, $choiceID) {

    }

    public function delete($id) {

    }
}
?>