<div class="container border border-dark p-4">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#ivc-create-package-form">Create</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#ivc-update-package-form">Update</a></li>
        <li class="nav-item"><a class="nav-link"data-toggle="pill" href="#ivc-delete-package-form">Delete</a></li>
    </ul>

    <div class="tab-content">
        <div id="ivc-create-package-form" class="tab-pane container active">
            <h2 class="text-center">Create Packages</h2>
            <form>
                <div class="form-group">
                    <label>Select a video</label>
                    <select id="create-package-select-video" Name="VideoId" onchange="updateCreatePackageVideoFilePath()" class="form-control"></select>
                </div>

                <div class="form-group">
                    <label>Title</label>
                    <input id="create-package-title" name="Title" placeholder="Name the package..." Type="text" class="form-control"/>
                </div>
            <input name="InstructorID" Type="hidden" value=<?php echo "\""; echo $instructorID; echo "\""; ?>/>
            <div class="form-group">
                <label>Selected video</label>
                <video-js
                    id="Create-Package-video"
                    controls 
                    data-setup="{}">
                    <source id="create-video-source" src="http://clips.vorwaerts-gmbh.de/VfE_html5.mp4" type="video/mp4">
                </video-js>
            </div>
            <button class="form-control mt-3 btn btn-primary" type="button" onclick="createPackage()">Create</button>
            <div id="ivc-create-package-status-message"></div>
            
        </form>  
        </div>

        <div id="ivc-update-package-form" class="tab-pane container fade">
            <h2 class="text-center">Update Packages</h2>
            <form method="Post" action="../api/Packages/Update.php"> 
            <div class="form-group">
                <label>Select an existing package</label>
                <select id="update-package-selection" class="form-control" name="ID" onchange="updateUpdatePackageOnNewPackageSelected()"></select>
            </div>

            <div class="form-group">
                <label>Title</label>
                <input id="update-package-title" name="Title" placeholder="Name the package..." Type="text" class="form-control"/>
            </div>

            <div class="form-group">
                <label>Select new video</label>
                <select id="update-package-select-video" name="VideoID" class="form-control" onchange="updateUpdatePackageVideoFilePath()">
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
            </div>
            <input name="InstructorID" Type="hidden" value=<?php echo "\""; echo $instructorID; echo "\""; ?>/>
            <label>Selected video</label>
            <video-js
                id="Update-Package-video"
                controls 
                data-setup="{}">
                <source src="http://clips.vorwaerts-gmbh.de/VfE_html5.mp4" type="video/mp4">
            </video-js>
            
            <button class="form-control mt-3 btn btn-warning" type="Submit">Update</button>
            </form>
        </div>

        <div id="ivc-delete-package-form" class="tab-pane container fade">
            <h2 class="text-center">Delete Packages</h2>
            <form> 
                <div class="form-group">
                    <label>Select a package to delete</label>
                    <select id="delete-package-selection" class="form-control" name="id"></select>
                </div>
                <input name="ID" type="hidden"/>
                <button class="form-control mt-3 btn btn-danger" type="button" onclick="deletePackage()">Delete</button>
                <div id="ivc-delete-package-status-message"></div>
            </form>
        </div>

    </div>
</div>
<script src="../js/Package-component.js"></script>
