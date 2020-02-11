<?php

class VideoController {

    private $conn;
    private $instructorId;
    private $videoFile;
    private $fileName;
    private $filePath;
    private $table = 'videos';

    public function __construct($db, $instructorId, $videoFile, $fileName, $filePath)
    {
        $this->conn = $db;
        $this->instructorId = $instructorId;
        $this->videoFile = $videoFile;
        $this->fileName = $fileName;
        $this->filePath = $filePath;
    }

    public function create()
    {
        $this->instructorId = htmlspecialchars(strip_tags($this->instructorId));
        $this->filePath = htmlspecialchars(strip_tags($this->filePath));
        $this->fileName = htmlspecialchars(strip_tags($this->fileName));

        $query = "INSERT INTO $this->table (`InstructorID`, `FilePath`, `Title`) VALUES (?,?,?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            $stmt->bind_param("iss", $this->instructorId, $this->filePath, $this->fileName);
            return $stmt->execute();
        }
        return false;
    }

    public function get($id)
    {
        $query = "Select * from $this->table where `ID` = ?";
        $stmt = $this->conn->prepare($query);
        if($stmt == false){
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        }else {
            $stmt->bind_param("s", $id);
            return $stmt->execute();
        }
        return false;

    }
}

?>
