<div class="section-title">
    Add Questions to Package
</div><!-- >End End section<!-->
<div class="flex-container">
    <form class="flex-item grow-2">
        <div class="label">Select a Package</div>
        <select class="PushLeft1" name="select-package" id="select-package" onchange="getVideo()">
        
        </select>
        <br />
        <br />
        <div class="label">Select a Question</div>
        <select class="PushLeft1" name="select-question" id="select-question">
        
        </select>
        <br />
        <br />
        <div class="label">Time Stamp</div>
        <input name="timestamp" id="TimeStamp" onkeyup="updateVideoTime()" type="string" class="PushLeft1" />
        <br />
        <br />
        <button onclick="sendData()" type="button" class="button-positive">Add to Package</button>
    </form><!-- >End Flex item <!-->
    <div id="message"></div>
    <div class="flex-item grow-1">
        <div class="label">
            Selected Package <span id="selectedPkge"></span>
        </div>
				
        <!--<video class="PushLeft1 small-video" id="videoPlayer" src="http://clips.vorwaerts-gmbh.de/VfE_html5.mp4" type="video/mp4" onclick="this.play()" controls>
            </video> -->

     <video-js
     id="AddQuestions-video"
     controls 
     autoplay
     data-setup="{}"
		 >
       <source id="ivc-add-questions-player-src" type="video/mp4">
     </video-js>

        <br />
        <div class="label">
            Question at Time Stamp
        </div>
        <div class="PushLeft1" id="QuestionDisplay">
        </div>
    </div><!-- >End Flex item <!-->
</div><!-- >End Flex Container <!-->
<script src="../js/UpdateVideoTime.js"></script>

<script src="../js/add-questions-component.js"></script>
