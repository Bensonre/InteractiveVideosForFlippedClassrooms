<?php
    $packageResponse = file_get_contents("http://localhost/Capstone/InteractiveVideosForFlippedClassrooms/src/api/Packages/read-all-with-instructor-id.php?instructorId=99");
    $packageResponse = json_decode($packageResponse, true);
    $videoResponse = file_get_contents("http://localhost/Capstone/InteractiveVideosForFlippedClassrooms/src/api/videos/read-all-with-instructor-id.php?instructorId=99");
    $videoResponse = json_decode($videoResponse, true);
?>
<div class="container border border-dark p-4">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#ivc-create-package-form">Create</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#ivc-update-package-form">Update</a></li>
        <li class="nav-item"><a class="nav-link"data-toggle="pill" href="#ivc-delete-package-form">Delete</a></li>
    </ul>

    <div class="tab-content">
        <div id="ivc-create-package-form" class="tab-pane container active">
            <h2 class="text-center">Create Package</h2>
            <form method="Post" action="../api/Packages/create.php">
            <div class="label">Select a video</div>
            <select id="create-package-select-video" Name="VideoId" onchange="updateCreatePackageVideoFilePath()" class="PushLeft1">
            <?php
                    foreach($videoResponse as $video){
                        echo "<option video-path=\"";
                        if(!array_key_exists('filePath', $video)){
                            echo"Invlaid Package";
                        }else{
                            echo $video['filePath'];
                         }
                        echo "\" value=";
                        if(!array_key_exists('id', $video)){
                            echo"Invlaid Package";
                        }else{
                            echo $video['id'];
                         }
                        echo ">";
                        if(!array_key_exists('title', $video)){
                            echo"Invlaid Package";
                        }else{
                            echo $video['title'];
                         }
                        echo "</option>";
                    }
                ?>
            </select>
            <div class="label">
                Title the Package
            </div>
            <input name="Title" placeholder="Package Name" Type="text" class="PushLeft1"/>
            <label class="label">
                Selected Video
            </label>
            <video-js
                id="Create-Package-video"
                controls 
                data-setup="{}">
                <source id="create-video-source" src="http://clips.vorwaerts-gmbh.de/VfE_html5.mp4" type="video/mp4">
            </video-js>
            <button class="form-control mt-3 btn btn-primary" type="Submit">Submit</button>
            
        </form>  
        </div>

        <div id="ivc-update-package-form" class="tab-pane container fade">
            <h2 class="text-center">Update Packages</h2>
            <form method="Post" action="../api/Packages/update.php"> 
            <div class="label">Select an exsisting package</div>
            <select id="update-package-selection" class="PushLeft1" name="Id" onchange="updateUpdatePackageOnNewPackageSelected()">
                <?php
                    foreach($packageResponse as $package){
                        echo "<option video-id=\"";
                        if(!array_key_exists('videoId', $package)){
                            echo"error";
                        }else{
                            echo $package['videoId'];
                        }
                        echo "\" value=";
                        if(!array_key_exists('id', $package)){
                            echo"error";
                        }else{
                            echo $package['id'];
                         }
                        echo ">";
                        if(!array_key_exists('title', $package)){
                            echo"error";
                        }else{
                            echo $package['title'];
                         }
                        echo "</option>";
                    }
                ?>
            </select>
            <label class="label"> Package Title </label>
            <input id="update-package-title" name="Title" placeholder="Package Name" Type="text" class="PushLeft1"/>
            <div class="label">Select New video</div>
            <select id="update-package-select-video" name="videoID" class="PushLeft1" onchange="updateUpdatePackageVideoFilePath()">
            <?php
                    foreach($videoResponse as $video){
                        echo "<option video-path=\"";
                        if(!array_key_exists('filePath', $video)){
                            echo"Invlaid Package";
                        }else{
                            echo $video['filePath'];
                        }
                        echo "\" value=";
                        if(!array_key_exists('id', $video)){
                            echo"Invlaid Package";
                        }else{
                            echo $video['id'];
                         }
                        echo ">";
                        if(!array_key_exists('title', $video)){
                            echo"Invlaid Package";
                        }else{
                            echo $video['title'];
                         }
                        echo "</option>";
                    }
                ?>
            </select>
            
            <label class="label">
                Selected Video
            </label>
            <video-js
                id="Update-Package-video"
                controls 
                data-setup="{}">
                <source src="http://clips.vorwaerts-gmbh.de/VfE_html5.mp4" type="video/mp4">
            </video-js>
            
            <button class="form-control mt-3 btn btn-primary" type="Submit">Update</button>
            </form>
        </div>

        <div id="ivc-delete-package-form" class="tab-pane container fade">
            <h2 class="text-center">Delete Packages</h2>
            <form method="Post" action="../api/Packages/update.php"> 
                <div class="label">Select a Package to delete</div>
                <select class="PushLeft1" name="ExistingTitle">
                <?php
                    foreach($packageResponse as $package){
                        echo "<option video-id=\"";
                        if(!array_key_exists('videoId', $package)){
                            echo"error";
                        }else{
                            echo $package['videoId'];
                        }
                        echo "\" value=";
                        if(!array_key_exists('id', $package)){
                            echo"error";
                        }else{
                            echo $package['id'];
                         }
                        echo ">";
                        if(!array_key_exists('title', $package)){
                            echo"error";
                        }else{
                            echo $package['title'];
                         }
                        echo "</option>";
                    }
                ?>
                </select>
                <input name="ID" type="hidden"/>
                <button class="form-control mt-3 btn btn-danger" type="Submit">Delete</button>
            </form>
        </div>

    </div>
</div>
<script src="../js/Package-component.js"></script>
