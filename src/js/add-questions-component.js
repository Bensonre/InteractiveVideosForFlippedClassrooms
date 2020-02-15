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
    getVideo();
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

    var info = {"packageID":packageID, "questionID":questionID, "instructorID":99, "timestamp":timestamp}; // TODO: update with actual id
    console.log(JSON.stringify(info));
    document.getElementById("ivc-add-questions-status-message").innerText = "Processing...";

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            document.getElementById("ivc-add-questions-status-message").innerText = res.message;

            if (res.success) {
                document.getElementById("ivc-add-questions-status-message").style.color = "green";
            } else {
                document.getElementById("ivc-add-questions-status-message").style.color = "red";
            }
        }
    };
    xhttp.open("POST", "../api/videoquestions/create.php", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + JSON.stringify(info));
}

function getVideo() {
    var packageID = document.getElementById("select-package").value;
    console.log("Getting video associated with package id: " + packageID);

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var res = JSON.parse(this.responseText);
            console.log("filePath: " + res.filePath);
            var player = videojs('AddQuestions-video');
            player.src(res.filePath);
            player.load();
        }
    };
    xhttp.open("GET", "../api/Packages/get-package-video.php?id=" + packageID, false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}