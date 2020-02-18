<?php

class VideoController {

    private $conn;
    private $table = 'videos';

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create($instructorId, $videoFile, $fileName, $filePath)
    {
        $instructorId = htmlspecialchars(strip_tags($instructorId));
        $filePath = htmlspecialchars(strip_tags($filePath));
        $fileName = htmlspecialchars(strip_tags($fileName));

        $query = "INSERT INTO $this->table (`InstructorID`, `FilePath`, `Title`) VALUES (?,?,?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            $stmt->bind_param("iss", $instructorId, $filePath, $fileName);
            return $stmt->execute();
        }
        return false;
    }

    public function read($id)
    {
        $query = "SELECT * FROM $this->table WHERE `ID` = ?";
        $stmt = $this->conn->prepare($query);
        if($stmt == false){
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        }else {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return $stmt;
        }
        return false;
    }

    public function readAllWithInstructorId($instructorId)
    {
        $query = "SELECT * FROM $this->table WHERE `InstructorID` = ?";
        $stmt = $this->conn->prepare($query);
        if($stmt == false){
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        }else {
            $stmt->bind_param("i", $instructorId);
            $stmt->execute();
            return $stmt;
        }
        return false;
    }
}

?>
