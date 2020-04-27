<div class="container border border-dark p-4">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#ivc-create-video-form">Upload</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#ivc-update-video-form">Update</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#ivc-delete-video-form">Delete</a></li>
    </ul>

    <div class="tab-content">
        <div id="ivc-create-video-form" class="tab-pane container active">
            <h2 class="text-center">Upload Video</h2>

            <form id="uvideoform" method="POST" enctype="multipart/form-data" target="hidden-frame">
                <input id="ivc-upload-progress" type="hidden" value="uvideoform" name="<?php echo ini_get("session.upload_progress.name"); ?>">

                <div class="form-group">
                    <label>Provide a link to an unlisted YouTube video</label>
                    <input id="ivc-video-link-create" type="text" class="form-control" placeholder="Unlisted YouTube URL..."></input>
                </div>

                <div class="form-group">
                    <label>Or select a video file from your computer</label>
                    <input id="ivc-video-select-create" type="file" accept="video/*" class="form-control-file" name="local-video-file" accept="video/*">
                </div>

                <div class="form-group">
                    <label>Title</label>
                    <input id="ivc-video-title-create" type="text" class="form-control" placeholder="Name the video..."></input>
                </div>

                <button class="form-control mt-3 btn btn-primary" type="submit" onclick="createVideo();">Upload</button>

                <div class="row">
                    <div class="col">
                        <div id="ivc-progress-bar">
                            <div id="ivc-progress-bar-color"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <div id="ivc-progress-bar-status"></div>
                    </div>
                </div>

                <div id="ivc-create-video-status-message" class="text-center"></div>
            </form>
            <iframe id="hidden-frame" name="hidden-frame" src="about:blank" hidden></iframe>
        </div>

        <div id="ivc-update-video-form" class="tab-pane container fade">
            <h2 class="text-center">Update Videos</h2>
            <form id="upvideoform"> 
                <div class="form-group">
                    <label>Video</label>
                    <select id="ivc-video-select-update" class="form-control"></select>
                </div>

                <div class="form-group">
                    <label>Title</label>
                    <input id="ivc-title-update" type="text" class="form-control" placeholder="Change the title..."></input>
                </div>

                <button class="form-control mt-3 btn btn-warning" type="button" onclick="updateVideo()">Update</button>
                <div id="ivc-update-video-status-message" class="text-center"></div>
            </form>
        </div>

        <div id="ivc-delete-video-form" class="tab-pane container fade">
            <h2 class="text-center">Delete Videos</h2>
                <div class="form-group">
                    <label>Video</label>
                    <select id="ivc-video-select-delete" class="form-control"></select>
                </div>

                <button class="form-control mt-3 btn btn-danger" type="button" onclick="deleteVideo()">Delete</button>
                <div id="ivc-delete-video-status-message" class="text-center"></div>
        </div>

    </div>
</div>
