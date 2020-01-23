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
        $this->fileName = $fileName;
        $this->filePath = $filePath;
    }

    public function create()
    {
        $this->instructorId = htmlspecialchars(strip_tags($this->instructorId));
        $this->filePath = htmlspecialchars(strip_tags($this->filePath));
        $this->fileName = htmlspecialchars(strip_tags($this->fileName));

        $query = "INSERT INTO 
                    $this->table
                  SET
                    instructorID = ?
                    FilePath = ?
                    Title = ?";

        if ($stmt = mysqli_prepare($this->conn, $query)) {
            $stmt->bind_param("i", $this->instructorId);
            $stmt->bind_param("s", $this->filePath);
            $stmt->bind_param("s", $this->fileName);

            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $result);
            mysqli_stmt_fetch($stmt);
        }

        return $result;
    }
}

?>
