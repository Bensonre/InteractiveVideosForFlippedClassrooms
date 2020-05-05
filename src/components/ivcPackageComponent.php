<div class="container border border-dark p-4">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#ivc-create-package-form"
            onclick="setCurrentPackageComponentTab(ivcPackageComponentTabs.CREATE);">Create</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#ivc-update-package-form"
            onclick="setCurrentPackageComponentTab(ivcPackageComponentTabs.UPDATE);">Update</a></li>
        <li class="nav-item"><a class="nav-link"data-toggle="pill" href="#ivc-delete-package-form"
            onclick="setCurrentPackageComponentTab(ivcPackageComponentTabs.DELETE);">Delete</a></li>
        <li class="nav-item"><a class="nav-link"data-toggle="pill" href="#ivc-duplicate-package-form"
            onclick="setCurrentPackageComponentTab(ivcPackageComponentTabs.DUPLICATE);">Duplicate</a></li>   
    </ul>

    <div class="tab-content">
        <div id="ivc-create-package-form" class="tab-pane container active">
            <h2 class="text-center">Create Package</h2>
            <div class="row">
                <div class="col">
                    <form id="cpackageform">
                        <div class="form-group">
                            <label>Select a video</label>
                            <select id="create-package-select-video" Name="VideoId" class="form-control"></select>
                        </div>

                        <div class="form-group">
                            <label>Package Title</label>
                            <input id="create-package-title" name="Title" placeholder="Name the package..." Type="text" class="form-control"/>
                        </div>

                        <input name="InstructorID" Type="hidden" value=<?php echo "\""; echo $instructorID; echo "\""; ?>/>
                        

                        <button class="form-control mt-3 btn btn-primary" type="button" onclick="createPackage()">Create</button>
                        <div id="ivc-create-package-status-message" class="text-center"></div>
                    </form>  
                </div>

                <div class="col">
                    <div class="form-group">
                        <label>Selected video</label>
                        <video
                            id="Create-Package-video"
                            class="video-js vjs-default-skin vjs-16-9"
                            autoplay
                            controls 
                            data-setup='{ "techOrder": ["youtube", "html5"] }'>
                            <source id="create-video-source" src="?" type="video/mp4">
                        </video>
                    </div>
                </div>
            </div>
        </div>
        <div id="ivc-duplicate-package-form" class="tab-pane container fade">
            <h2 class="text-center">Duplicate Package</h2>
            <div class="row">
                <div class="col">
                    <form> 
                        <div class="form-group">
                            <label>Select an existing package</label>
                            <select id="duplicate-package-selection" class="form-control" name="ID" onchange="updateDuplicatePackageOnNewPackageSelected()"></select>
                        </div>

                        <div class="form-group">
                            <label>Package Title</label>
                            <input id="duplicate-package-title" name="Title" placeholder="Name the package..." Type="text" class="form-control"/>
                        </div>

                        <input name="InstructorID" Type="hidden" value=<?php echo "\""; echo $instructorID; echo "\""; ?>/>
                        
                    
                        <button class="form-control mt-3 btn btn-warning" type="button" onclick="duplicatePackage()">Duplicate</button>
                        <div id="ivc-duplicate-package-status-message" class="text-center"></div>
                    </form>
                </div>
            </div>
        </div>
        <div id="ivc-update-package-form" class="tab-pane container fade">
            <h2 class="text-center">Update Package</h2>
            <div class="row">
                <div class="col">
                    <form id="uppackageform"> 
                        <div class="form-group">
                            <label>Select an existing package</label>
                            <select id="update-package-selection" class="form-control" name="ID"></select>
                        </div>

                        <div class="form-group">
                            <label>Package Title</label>
                            <input id="update-package-title" name="Title" placeholder="Name the package..." Type="text" class="form-control"/>
                        </div>

                        <div class="form-group">
                            <label>Select new video</label>
                            <select id="update-package-select-video" name="VideoID" class="form-control"></select>
                        </div>

                        <input name="InstructorID" Type="hidden" value=<?php echo "\""; echo $instructorID; echo "\""; ?>/>
                        
                    
                        <button class="form-control mt-3 btn btn-warning" type="button" onclick="updatePackage()">Update</button>
                        <div id="ivc-update-package-status-message" class="text-center"></div>
                    </form>
                </div>

                <div class="col">
                    <div class="form-group">
                        <label>Selected video</label>
                        <video
                            id="Update-Package-video"
                            class="video-js vjs-default-skin vjs-16-9"
                            autoplay
                            controls 
                            data-setup='{ "techOrder": ["youtube", "html5"] }'>
                            <source id="create-video-source" src="?" type="video/mp4">
                        </video>
                    </div>
                </div>

            </div>
        </div>

        <div id="ivc-delete-package-form" class="tab-pane container fade">
            <h2 class="text-center">Delete Package</h2>
            <form> 
                <div class="form-group">
                    <label>Select a package to delete</label>
                    <select id="delete-package-selection" class="form-control" name="id"></select>
                </div>
                <input name="ID" type="hidden"/>
                <button class="form-control mt-3 btn btn-danger" type="button" onclick="deletePackage()">Delete</button>
                <div id="ivc-delete-package-status-message" class="text-center"></div>
            </form>
        </div>
    </div>
</div>
