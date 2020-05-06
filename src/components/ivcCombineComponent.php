
<div class="container border border-dark">
    <h2 class="text-center">Add Questions to a Package</h2>

    <div class="row">
        <div class="col">
            <form id="addqtpform">
                <div class="form-group">
                    <div class="label" for="select-package">Select a Package</div>
                    <select class="form-control" name="select-package" id="select-package" onchange="packageChanged()"></select>
                </div>
                <div class="form-group">
                    <div class="label" for="select-question">Select a Question</div>
                    <select class="form-control" name="select-question" id="select-question"></select>
                </div>
                <div class="form-group">
                    <div class="label" for="timestamp">Timestamp</div>
                    <input class="form-control" name="timestamp" id="timestamp" onchange="timeFieldChanged()" oninput="timeFieldChanged()"
                        onkeypress="timeFieldChanged()" onfocus="timeFieldOnFocus()" onfocusout="timeFieldFocusOut()" type="string" /> 
                </div>
                <div class="form-group">
                    <button class="form-control mb-3 btn btn-primary" onclick="sendData()" type="button" class="">Add to Package</button>
                    <div class="text-center" id="ivc-add-questions-status-message"></div>
                </div>
            </form>
        </div>

        <div class="col align-self-center">
            <div class="form-group">
                <video
                    id="ivc-add-questions-player"
                    class="video-js vjs-default-skin vjs-16-9"
                    controls 
                    data-setup='{ "techOrder": ["youtube", "html5"] }'>
                <source src="?"type="video/mp4">
                </video>
            </div>
        </div>
    </div>
    
    <div class="row justify-content-center">
    <div class="col-auto">
        <table class="table table-bordered table-responsive table-hover" id="ivc-add-questions-added-table"></table>
    </div>
    </div>
</div>
