<?php
class AnswerController {

    private $conn;
    private $table = 'studentanswers';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($studentID, $questionID, $choiceID, $packageID) {
        $questionID = htmlspecialchars(strip_tags($questionID));
        $choiceID = htmlspecialchars(strip_tags($choiceID));
        $studentID = htmlspecialchars(strip_tags($studentID));
        $packageID = htmlspecialchars(strip_tags($packageID));

        $query = "INSERT INTO $this->table (`StudentID`, `PackageID`, `QuestionID`, `ChoiceID`, `AnswerDate`) VALUES (?,?,?,?,CURDATE())";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            $stmt->bind_param("iiii", $studentID, $packageID, $questionID, $choiceID);
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
            return $stmt->get_result()->fetch_assoc();
        }
        return null;
    }

    public function readAnsweredQuestions($packageID, $studentID) {
        $packageID = htmlspecialchars(strip_tags($packageID));
        $studentID = htmlspecialchars(strip_tags($studentID));

        $query = "SELECT `QuestionID`, `ChoiceID` FROM $this->table WHERE `PackageID` = ? AND `StudentID` = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            $stmt->bind_param("ii", $packageID, $studentID);
            $stmt->execute();
            $res = $stmt->get_result();
            $num = mysqli_num_rows($res);
            $result = array(
                "Questions" => $questions = [] 
            );
            if ($num > 0) {
                while($row = mysqli_fetch_assoc($res)) {
                    do {
                        $QuestionObj = [
                        "QuestionID" => $row["QuestionID"],
                        "ChoiceID" => $row["ChoiceID"]
                        ];
                
                        array_push($result["Questions"], $QuestionObj);
                    } while($row =  mysqli_fetch_assoc($res));
                }
                http_response_code(200);
            } else {
                http_response_code(404);
            }
            return $result;
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