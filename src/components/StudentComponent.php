<?php
$packageId = intval($_GET['id']); 
    if(!$packageId){
        $packageId=1;
    }
    $response = file_get_contents("http://localhost/Capstone/InteractiveVideosForFlippedClassrooms/src/api/packages/read-one.php?id=$packageId");
    $response = json_decode($response, true);
?>

<div class="section-title">
            <div ID="Package_Title">
            <?php
                if(!array_key_exists('Title', $response)){
                        echo"Invlaid Package ID $packageId";
                }else{
                    echo $response['Title'];
                }
             ?>
            </div>
        </div><!-- >End End section<!-->
						<video-js

						id="videoPlayer"
						
						controls 
						
						data-setup="{}">
                                <?php
                                $path = $response['Path'];
								echo"<source src='$path' type='video/mp4'>";
                                ?>
						</video-js>
            <div class="video-bar">
                <div id="Question-Modal">
                    <div class="up-triangle"></div>
                    <div class="question-container">
                        <?php
                                $i=0;
                                foreach($response['Questions'] as $question){
                                    if($question['QuestionID'] == $response['Questions'][0]['QuestionID']){
                                        echo "<div id='question$i' class='student-question'>";
                                    }else{
                                        echo '<div class="hidden student-question">';
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
                            ?>
                       <div>
                            <button id="question-submit" type=button class="button-positive">submit</btn>
                       </div> 
                    </div>
                </div>
    <script src="../js/DisplayQuestions.js"></script>
