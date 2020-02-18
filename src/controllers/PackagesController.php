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

    private function sendQuery($q) {
        $query = $this->conn->prepare($q);
        if ($query == false) {
          $error = $this->conn->errno . ' ' . $this->conn->error;
          echo $error;
          return False;
        } else {
          $query->execute();
          return $query;
        }
    }


    public function delete($id){
        $id = htmlspecialchars(strip_tags($id));

        $query = "DELETE FROM $this->PackageTable WHERE `ID` = ?";
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
    
    public function create($Title, $videoId, $Date){
        $this->Date = htmlspecialchars(strip_tags($Date));
        $this->Title = htmlspecialchars(strip_tags($Title));
        $videoId = htmlspecialchars(strip_tags($videoId));

        $query = "INSERT INTO $this->PackageTable (`Title`, `VideoID`, `Date`) VALUES (???)";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            $stmt->bind_param("sis", $this->Title, $videoId, $this->date);
            return $stmt->execute();
        }
    }

    public function Update($id, $Title, $videoId, $Date){
        $this->Date = htmlspecialchars(strip_tags($Date));
        $this->Title = htmlspecialchars(strip_tags($Title));
        $videoId = htmlspecialchars(strip_tags($videoId));
        $querySetString = null;
        $valuesString = null;
        $bindParamString = null;

        $query = "UPDATE $this->PackageTable SET (`Title`, `VideoID`, `Date`) VALUES (???) where ID=(?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            $stmt->bind_param("sisi", $this->Title, $videoId, $this->date, $id);
            return $stmt->execute();
        }
    }

    public function readAllWithInstructorId($instructorId) {
        $instructorId = htmlspecialchars(strip_tags($instructorId));

        $query = "SELECT * FROM $this->PackageTable WHERE `InstructorID` = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            $stmt->bind_param("i", $instructorId);
            $stmt->execute();
            return $stmt;
        }
    }

    public function getVideoIdOfPackage($id) {
        $query = "SELECT `VideoID` FROM $this->PackageTable WHERE `ID` = $id";
        $stmt = $this->conn->prepare($query);
        $videoId = null;
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            if($stmt->execute()) {
                $stmt->bind_result($videoId);
                $stmt->fetch();
                return $videoId;
            } else {
                return null;
            }
        }
    }

    public function getPackageWithVideo($id)
    {
        $query = "Select FilePath, p.Title, PackageID, video_questions.QuestionID, QuestionTimeStamp, QuestionText, c.id As ChoiceID, ChoiceText, ChoiceOrder, correct from video_questions 
		Join videos on video_questions.VideoID = videos.ID
        Join packages As p on video_questions.PackageID = p.ID
        Join questions on video_questions.QuestionID = Questions.ID
        inner join choices As c on video_questions.QuestionID = c.QuestionID
        where PackageID = ?
        ORDER BY video_questions.QuestionID, ChoiceOrder ASC;";
        $stmt = $this->conn->prepare($query);
        if($stmt == false){
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo "Error in Get Packages with video path";
            echo $error;
        }else {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt;
        }
        return false;
    }

    public function getPackages()
    {
        $query = "Select FilePath, p.Title, PackageID, video_questions.QuestionID, QuestionTimeStamp, QuestionText, c.id As ChoiceID, ChoiceText, ChoiceOrder, correct from video_questions 
		Join videos on video_questions.VideoID = videos.ID
        Join packages As p on video_questions.PackageID = p.ID
        Join questions on video_questions.QuestionID = Questions.ID
        inner join choices As c on video_questions.QuestionID = c.QuestionID
        ORDER BY PackageID,video_questions.QuestionID, ChoiceOrder ASC;";
        $stmt = $this->conn->prepare($query);
        if($stmt == false){
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo "Error in Get Packages with video path";
            echo $error;
        }else {
        $stmt->execute();
        return $stmt;
        }
        return false;
    }
}

?>
