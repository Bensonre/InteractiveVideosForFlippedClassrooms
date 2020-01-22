<?php

class VideoController {

    private $conn;
    private $instructorId;
    private $videoFile;
    private $fileName;
    private $filePath;
    private $table = 'Videos';

    public function __construct($db, $instructorId, $videoFile, $fileName, $filePath)
    {
        $this->conn = $db;
        $this->instructorId = $instructorId;
        $this->videoFile = $videoFile;
        $this->filePath = $filePath;
    }

    public function create()
    {
        $query = "INSERT INTO 
                    $this->table
                  SET
                    instructorID = :instructorId
                    FilePath = :filepath
                    Title = :title";

        $stmt = $this->conn->prepare($query);

        $this->instructorId = htmlspecialchars(strip_tags($this->instructorId));
        $this->filePath = htmlspecialchars(strip_tags($this->filePath));
        $this->fileName = htmlspecialchars(strip_tags($this->fileName));

        $stmt->bindParam(':instructorId', $this->instructorId);
        $stmt->bindParam(':filepath', $this->filePath);
        $stmt->bindParam(':title', $this->fileName);

        $stmt->execute();

        return $stmt;
    }
}

?>
