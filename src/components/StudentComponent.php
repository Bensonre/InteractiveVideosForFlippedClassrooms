<?php
$packageId = intval($_GET['id']); 
    if(!$packageId){
        $packageId=1;
    }
    $response = file_get_contents("http://web.engr.oregonstate.edu/~bensonre/Capstone/src/api/packages/get.php?id=$packageId");
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
                    <div class="question-container">container
                        <div>
                            What is the answer
                        </div>
                        <div>
                           <input type="radio" class="radio" name="answer"><span>A</span><br/>
                           <input type="radio" class="radio" name="answer"><span>B</span><br/>
                           <input type="radio" class="radio" name="answer"><span>C</span><br/>
                           <input type="radio" class="radio" name="answer"><span>D</span><br/>
                        </div>
                       <div>
                            <button id="question-submit" type=button class="button-positive">submit</btn>
                       </div> 
                    </div>
                </div>
    <script src="../js/DisplayQuestions.js"></script>
