<div class="container border border-dark p-4">
    <ul class="nav nav-pills">
        <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#ivc-create-video-form">Create</a></li>
        <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#ivc-update-video-form">Update</a></li>
        <li class="nav-item"><a class="nav-link"data-toggle="pill" href="#ivc-delete-video-form">Delete</a></li>
    </ul>

    <div class="tab-content">
        <div id="ivc-create-video-form" class="tab-pane container active">
            <h2 class="text-center">Upload Videos</h2>
            <form>
                <div class="form-group">
                    <label>Video</label>
                    <input id="ivc-video-select-create" type="file" class="form-control-file" name="local-video-file">
                </div>

                <div class="form-group">
                    <label>Title</label>
                    <input id="ivc-video-title-create" type="text" class="form-control" placeholder="Name the video..."></input>
                </div>

                <button class="form-control mt-3 btn btn-primary" type="button" onclick="createVideo()">Create</button>
                <div id="ivc-create-video-status-message" class="text-center"></div>
            </form>
        </div>

        <div id="ivc-update-video-form" class="tab-pane container fade">
            <h2 class="text-center">Update Videos</h2>
            <form> 
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
