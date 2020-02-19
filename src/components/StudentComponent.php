<?php
include "../includes/Display_Question_Component.php";
$packageId = intval($_GET['id']);
    if($packageId==Null){
        $packageId=1;
    }
    $response = file_get_contents("http://web.engr.oregonstate.edu/~bensonre/Capstone/src/api/Packages/read-one.php?id=$packageId");
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
                                getQuestionHtml($response)
                            ?>
                    </div>
                </div>
    <script src="../js/DisplayQuestions.js"></script>
