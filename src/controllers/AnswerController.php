<?php
class AnswerController {

    private $conn;
    private $table = 'studentanswers';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create($questionID, $choiceID, $studentID) {

    }

    public function read($questionID, $studentID) {

    }

    public function update($questionID, $studentID, $choiceID) {

    }

    public function delete($id) {

    }
}
?>