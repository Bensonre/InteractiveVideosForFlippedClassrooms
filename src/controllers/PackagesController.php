<?php

class PackageController {

    private $conn;
    private $PrimaryTable = 'video_questions';
    private $QuestionsTable = 'questions';
    private $PackageTable = 'packages';
    private $VideoTable = 'videos';
    private $Date = null;
    private $Title = null;
    
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function create(){
        $this->Date = htmlspecialchars(strip_tags($this->Date));
        $this->Title = htmlspecialchars(strip_tags($this->Title));

        $query = "INSERT INTO $this->PackageTable (`Date`, `Title`) VALUES (?,?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            $stmt->bind_param("ss", $this->Title, $this->Date);
            return $stmt->execute();
        }
    }

    public function getPackageWithVideo($id)
    {
        $query = "Select FilePath, p.Title, PackageID from video_questions 
		Join videos on video_questions.VideoID = videos.ID
        Join packages As p on video_questions.PackageID = p.ID
        where PackageID = ?;";
        $stmt = $this->conn->prepare($query);
        if($stmt == false){
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo "Error in Get Package with video path";
            echo $error;
        }else {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt;
        }
        return false;
    }
}

?>
