<?php

class PackageController {

    private $conn;
    private $PrimaryTable = 'package_questions';
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
    
    public function create($title, $instructorId, $videoId){
        $title = htmlspecialchars(strip_tags($title));
        $instructorId = htmlspecialchars(strip_tags($instructorId));
        $videoId = htmlspecialchars(strip_tags($videoId));

        $query = "INSERT INTO $this->PackageTable (`Title`, `VideoID`, `DateModified`, `InstructorID`) VALUES (?,?,CURDATE(),?)";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            $stmt->bind_param("sii", $title, $videoId, $instructorId);
            return $stmt->execute();
        }
    }

    public function update($id, $title, $instructorId, $videoId){
        $id = htmlspecialchars(strip_tags($id));
        $title = htmlspecialchars(strip_tags($title));
        $instructorId = htmlspecialchars(strip_tags($instructorId));
        $videoId = htmlspecialchars(strip_tags($videoId));
        $querySetString = null;
        $valuesString = null;
        $bindParamString = null;

        $query = "UPDATE $this->PackageTable SET `Title` = ?, `VideoID` = ?, `InstructorID` = ?, `DateModified` = CURDATE() where ID=?";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            $stmt->bind_param("siii", $title, $videoId, $instructorId, $id);
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
    public function readPackageIdsbyNewestFromData($title ,$instructorId, $videoId) {
        $instructorId = htmlspecialchars(strip_tags($instructorId));
        $title = htmlspecialchars(strip_tags($title));
        $videoId = htmlspecialchars(strip_tags($videoId));

        $query = "SELECT `ID` from $this->PackageTable where `Title` = ?
        && `InstructorID`=? && `VideoID`=?
        order by `DateModified` desc;";
        $stmt = $this->conn->prepare($query);
        if ($stmt == false) {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        } else {
            $stmt->bind_param("sii",$title ,$instructorId, $videoId);
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
        /* $query = "Select FilePath, IsYouTube, p.Title, PackageID, package_questions.QuestionID, QuestionTimeStamp, QuestionText, c.id As ChoiceID, ChoiceText, ChoiceOrder, correct from package_questions 
		Join videos on package_questions.VideoID = videos.ID
        Join packages As p on package_questions.PackageID = p.ID
        Join questions on package_questions.QuestionID = Questions.ID
        inner join choices As c on package_questions.QuestionID = c.QuestionID
        where PackageID = ?
        ORDER BY package_questions.QuestionID, ChoiceOrder ASC;"; */
        $query = "Select FilePath, IsYouTube, p.Title, PackageID, package_questions.QuestionID, QuestionTimeStamp, QuestionText, c.id As ChoiceID, ChoiceText, ChoiceOrder, correct from package_questions 
        Join packages As p on package_questions.PackageID = p.ID
        Join videos on p.VideoID = videos.ID
        Join questions on package_questions.QuestionID = Questions.ID
        inner join choices As c on package_questions.QuestionID = c.QuestionID
        where PackageID = ?
        ORDER BY package_questions.QuestionID, ChoiceOrder ASC;";
        $stmt = $this->conn->prepare($query);
        if($stmt == false){
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo "Error in Get Packages with video path";
            echo $error;
        } 
        else {
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $VideoResult = $stmt->get_result();
            $num = mysqli_num_rows($VideoResult);
            if ($num > 0) {
                while($row = mysqli_fetch_assoc($VideoResult)) {
                    $result = array(
                        "Title" => $row['Title'],
                        "Path" => $row['FilePath'],
                        "IsYouTube" => $row['IsYouTube'],
                        "Package"=>$row['PackageID'],
                        "Questions" => $questions = [],
                            
                    );
                    $package = $row['PackageID'];
                    do {
                        
                        $QuestionObj = [
                        "QuestionID" => $row["QuestionID"],
                        "QuestionTimestamp" => $row["QuestionTimeStamp"],
                        "QuestionText" => $row["QuestionText"],
                        "Answer" => $answers = []
                        ];
                
                        do {
                            $AnswerObj = [
                            "AnswerID" => $row["ChoiceID"],
                            "AnswerText" => $row["ChoiceText"],
                            "AnswerOrder" => $row["ChoiceOrder"]//,
                            //"Correct" => $row["correct"]
                            ];
                            
                            array_push($QuestionObj['Answer'], $AnswerObj);
                
                        } while( $row["ChoiceOrder"] < 4 && $package == $row['PackageID'] && $row =  mysqli_fetch_assoc($VideoResult));
                        
                    array_push($result["Questions"], $QuestionObj);
                    } while( $package == $row['PackageID'] && $row =  mysqli_fetch_assoc($VideoResult));
                }
                http_response_code(200);
            
                return $result;
            } else {
                http_response_code(404);
            
                return array();
            }
        }   
    }

    public function getPackages()
    {
        $query = "Select FilePath, p.Title, PackageID, package_questions.QuestionID, QuestionTimeStamp, QuestionText, c.id As ChoiceID, ChoiceText, ChoiceOrder, correct from package_questions 
		Join videos on package_questions.VideoID = videos.ID
        Join packages As p on package_questions.PackageID = p.ID
        Join questions on package_questions.QuestionID = Questions.ID
        inner join choices As c on package_questions.QuestionID = c.QuestionID
        ORDER BY PackageID,package_questions.QuestionID, ChoiceOrder ASC;";
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
