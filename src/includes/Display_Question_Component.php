<?php
    function getQuestionHtml($response){
        $i=0;
        foreach($response['Questions'] as $question){

            $questionID = $question['QuestionID'];
            if($question['QuestionID'] == $response['Questions'][0]['QuestionID']){
                echo "<form QuestionId='$questionID' id='question$i' class='student-question' method='POST' action='../api/answers/create.php'>";
            }else{
                echo "<form QuestionId='$questionID' id='question$i' class='hidden student-question' method='POST' action='../api/answers/create.php'>";
            }
            echo '<div>';
            echo $question['QuestionText'];
            echo '</div>';
            echo '<div>';
            foreach($question['Answer'] as $ans){
                echo '<input value="';
                echo $ans['AnswerID'];
                echo '" type="radio" class="radio Video-Question-Answer" name="choiceID"><span>';
                echo $ans['AnswerText'];
                echo '</span><br/>';
            }
            echo "<input type='hidden' value='$questionID' name='questionID'>";
            echo "<input type='hidden' value='1' name='studentID'>";
            echo '</div>';
            echo '<div><button id="question-submit" type="button" onclick="submitAnswer()" class="button-positive">submit</btn></div>';
            echo '</form>'; 
            echo '<div><button id="question-submit" type="button" class="button-positive">submit</btn></div>';
            echo '</form>';

            $i++;
        }
    }
?>