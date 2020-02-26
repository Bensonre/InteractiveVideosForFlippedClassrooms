
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
                    <input class="form-control" name="timestamp" id="timestamp" onkeyup="updateVideoTime()" type="string" /> 
                </div>
                <div class="form-group">
                    <button class="form-control mb-3 btn btn-primary" onclick="sendData()" type="button" class="">Add to Package</button>
                    <div class="text-center" id="ivc-add-questions-status-message"></div>
                </div>
            </form>
        </div>

        <div class="col align-self-center">
            <div class="form-group">
                <video-js
                    id="ivc-add-questions-player"
                    class="video-js vjs-16-9"
                    controls 
                    autoplay
                    data-setup="{}"
                >
                </video-js>
            </div>
        </div>
    </div>
    
        <div class="form-group">
        <table class="table table-dark table-bordered table-sm" id="ivc-add-questions-added-table"></table>
        </div>
</div>
