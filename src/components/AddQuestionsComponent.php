<div class="container">
    <div class="row">

        <div class="col m-4 border border-dark">
            <h2 class="text-center">Add Questions to a Package</h2>
            <form>
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
                <button class="form-control mb-3 btn btn-primary" onclick="sendData()" type="button" class="">Add to Package</button>
            </form>
            <div class="text-center" id="ivc-add-questions-status-message"></div>
        </div>

        <div class="col m-4 border border-dark">
            <div class="mt-4 mb-4" style="height: 50vh; overflow: auto;">
            <table class="table table-striped table-bordered table-sm" id="ivc-add-questions-added-table"></table>
            </div>
        </div>

        <div class="col m-4 border border-dark">
            <video-js
            id="ivc-add-questions-player"
            controls 
            autoplay
            data-setup="{}"
		        >
            </video-js>
        </div>

    </div>
</div>
