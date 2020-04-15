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

        $query = "INSERT INTO $this->table (`InstructorID`, `FilePath`, `Title`, `IsYouTube`, `DateModified`) VALUES (?,?,?,0,CURDATE())";
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

    public function createURL($instructorId, $fileName, $url)
    {
        $instructorId = htmlspecialchars(strip_tags($instructorId));
        $fileName = htmlspecialchars(strip_tags($fileName));
        $url = htmlspecialchars(strip_tags($url));

        $query = "INSERT INTO $this->table (`InstructorID`, `FilePath`, `Title`, `IsYouTube`, `DateModified`) VALUES (?,?,?,1,CURDATE())";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            $stmt->bind_param("iss", $instructorId, $url, $fileName);
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

    public function update($id, $title) {
        $id = htmlspecialchars(strip_tags($id));
        $title = htmlspecialchars(strip_tags($title));

        $query = "UPDATE $this->table SET `Title` = ? WHERE `ID` = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            return false;
        } else {
            $stmt->bind_param("si", $title, $id);
            return $stmt->execute();
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

    public function getInstructorVideos($instructorId) {
        $instructorId = htmlspecialchars(strip_tags($instructorId));

        $query = "SELECT * FROM $this->table WHERE `InstructorID` = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            return null;
        } else {
            $stmt->bind_param("i", $instructorId);
            $stmt->execute();
            return $stmt;
        }
        return null;
    }
}

?>
