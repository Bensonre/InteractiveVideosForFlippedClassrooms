<?php
    function getQuestionHtml($response){
        $i=0;
        foreach($response['Questions'] as $question){
            if($question['QuestionID'] == $response['Questions'][0]['QuestionID']){
                echo "<div id='question$i' class='student-question'>";
            }else{
                echo "<div id='question$i' class='hidden student-question'>";
            }
            echo '<div>';
            echo $question['QuestionText'];
            echo '</div>';
            echo '<div>';
            foreach($question['Answer'] as $ans){
                echo '<input type="radio" class="radio" name="answer"><span>';
                echo $ans['AnswerText'];
                echo '</span><br/>';
            }
            echo '</div>';
            echo '</div>';   
            $i++;
        }
    }
?>