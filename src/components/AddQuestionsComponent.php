<div class="section-title">
    Add Questions to Package
</div><!-- >End End section<!-->
<div class="flex-container">
    <form class="flex-item grow-2">
        <div class="label">Select a Package</div>
        <select class="PushLeft1" name="select-package" id="select-package">
        
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
        console.log("Getting packages and questions...");
        getPackages();
        getQuestions();
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

    function getQuestions() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log(this.responseText);
                var obj = JSON.parse(this.responseText);
                console.log("Questions received...");
                fillQuestions(obj);
            }
        };
        xhttp.open("GET", "../api/questions/read.php", true);
        xhttp.send();
    }
    
    function fillQuestions(obj) {
        console.log("Filling questions...");
        var i;
        for (i = 0; i < obj.length; i++) {
            console.log(obj[i]);
            let option = document.createElement("option");
            option.value = obj[i].QuestionID;
            let text = document.createTextNode(obj[i].QuestionText);
            option.appendChild(text);
            let element = document.getElementById("select-question");
            element.appendChild(option);
        }
    }

    function sendData() {
        var packageID = document.getElementById("select-package").value;
        var questionID = document.getElementById("select-question").value;
        var timestamp = document.getElementById("TimeStamp").value;

        var info = {"packageID":packageID, "questionID":questionID, "timestamp":timestamp};
        console.log(JSON.stringify(info));
        document.getElementById("message").innerText = "Processing...";

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var res = JSON.parse(this.responseText);
                document.getElementById("message").innerText = res.message;

                if (res.success) {
                    document.getElementById("message").style.color = "green";
                } else {
                    document.getElementById("message").style.color = "red";
                }
            }
        };
        xhttp.open("POST", "../api/videoquestions/create.php", false);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("data=" + JSON.stringify(info));
    }
</script>
