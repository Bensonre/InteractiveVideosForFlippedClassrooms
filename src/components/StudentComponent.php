<?php
   include_once '../database/Database.php';
   include_once '../controllers/PackagesController.php';
   $packageId = intval($_GET['id']); 
   if(!$packageId){
       $packageId=1;
   }
   $database = new Database();
   $db = $database->connect();
    
   $controller = new PackageController($db);
   $VideoResult = $controller->getPackageWithVideo($packageId);
?>

<div class="section-title">
            <div ID="Package_Title">
            <?php
                if(mysqli_num_rows($VideoResult)==0){
                        echo"Invlaid Package ID $packageId";
                }else{
                    $row = mysqli_fetch_assoc($VideoResult);
                    echo $row['Title'];
                }
             ?>
            </div>
        </div><!-- >End End section<!-->
						<video-js

						id="videoPlayer"
						
						controls 
						
						data-setup="{}">
                                <?php
                                $path = $row['FilePath'];
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
