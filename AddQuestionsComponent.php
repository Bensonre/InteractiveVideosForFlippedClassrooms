<div class="section-title">
    Add Questions to Package
</div><!-- >End End section<!-->
<div class="flex-container">
    <form class="flex-item grow-2" method="Post">
        <div class="label">Select a Package</div>
        <select class="PushLeft1"></select>
        <br />
        <br />
        <div class="label">Select a Question</div>
        <select class="PushLeft1"></select>
        <br />
        <br />
        <div class="label">Time Stamp</div>
        <input id="TimeStamp" onkeyup="updateVideoTime()" type="string" class="PushLeft1" />
        <br />
        <br />
        <button class="button-positive">Add to Package</button>
    </form><!-- >End Flex item <!-->
    <div class="flex-item grow-1">
        <div class="label">
            Selected Package <span id="selectedPkge"></span>
        </div>
        <video class="PushLeft1 small-video" id="videoPlayer" src="http://clips.vorwaerts-gmbh.de/VfE_html5.mp4" type="video/mp4" onclick="this.play()" controls>
            </video>
        <br />
        <div class="label">
            Question at Time Stamp
        </div>
        <div class="PushLeft1" id="QuestionDisplay">
        </div>
    </div><!-- >End Flex item <!-->
</div><!-- >End Flex Container <!-->
<script src="UpdateVideoTime.js"></script>