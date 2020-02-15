<link href="../css/ivc.css" rel="stylesheet">

<div class="ivc-container">
    <div class="section-title">Add Questions to a Package</div>
    <div class="quarter-width" id="ivc-add-questions-form-wrapper">
        <form>
            <div class="label">Select a Package</div>
            <select name="select-package" id="select-package" onchange="getVideo(); getQuestionsInSelectedPackage()"></select>
            <br />
            <br />
            <div class="label">Select a Question</div>
            <select name="select-question" id="select-question"></select>
            <br />
            <br />
            <div class="label">Time Stamp</div>
            <input name="timestamp" id="TimeStamp" onkeyup="updateVideoTime()" type="string" />
            <br />
            <br />
            <button onclick="sendData()" type="button" class="ivc-button-positive">Add to Package</button>
        </form>
        <div id="ivc-add-questions-status-message"></div>
    </div>

    <div class="quarter-width" id="ivc-add-questions-added-table-wrapper">
        <table id="ivc-add-questions-added-table"></table>
    </div>
				
    <div class="half-width" id="ivc-add-questions-player-wrapper">
        <video-js
        id="AddQuestions-video"
        controls 
        autoplay
        data-setup="{}"
		    >
        </video-js>
    </div>

</div> <!-- >End IVC Container <!-->

<script src="../js/UpdateVideoTime.js"></script>
<script src="../js/add-questions-component.js"></script>
