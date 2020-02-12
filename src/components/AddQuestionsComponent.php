<div class="section-title">
    Add Questions to Package
</div><!-- >End End section<!-->
<div class="flex-container">
    <form class="flex-item grow-2" method="Post">
        <div class="label">Select a Package</div>
        <select class="PushLeft1" name="select-package" id="select-package">
        
        </select>
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
				
        <!--<video class="PushLeft1 small-video" id="videoPlayer" src="http://clips.vorwaerts-gmbh.de/VfE_html5.mp4" type="video/mp4" onclick="this.play()" controls>
            </video> -->

     <video-js
     id="AddQuestions-video"
     controls 
     data-setup="{}"
		 >
       <source src="http://clips.vorwaerts-gmbh.de/VfE_html5.mp4" type="video/mp4">
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

<script>
    window.onload = function() {
        console.log("Getting packages...");
        getPackages();
    }

    function getPackages() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                var obj = JSON.parse(this.responseText);
                console.log("Packages received...");
                fillPackages(obj);
            }
        };
        xhttp.open("GET", "../api/Packages/read_all.php", true);
        xhttp.send();
    }
    
    function fillPackages(obj) {
        console.log("Filling packages...");
        var i;
        for (i = 0; i < obj.length; i++) {
            console.log(obj[i]);
            let option = document.createElement("option");
            option.value = obj[i].ID;
            let text = document.createTextNode(obj[i].Title);
            option.appendChild(text);
            let element = document.getElementById("select-package");
            element.appendChild(option);
        }
    }
</script>
