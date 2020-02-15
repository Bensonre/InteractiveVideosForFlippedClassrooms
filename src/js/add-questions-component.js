window.onload = function() {
    console.log("Getting packages and questions...");
    initializeMarkerPlugin();
    getPackages();
    getQuestions();
}

function initializeMarkerPlugin() {
    var player = videojs('AddQuestions-video');
    player.markers({});
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
    getQuestionsInSelectedPackage();
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

            getQuestionsInSelectedPackage();
        }
    };
    xhttp.open("POST", "../api/videoquestions/create.php", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + JSON.stringify(info));
}

function packageChanged() {
    getVideo();
    getQuestionsInSelectedPackage();
}

function getVideo() {
    var packageID = document.getElementById("select-package").value;
    console.log("Getting video associated with the selected package.");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            console.log("filePath: " + res.filePath);
            var player = videojs('AddQuestions-video');
            player.reset();
            player.src(res.filePath);
            player.load();
        }
    };
    xhttp.open("GET", "../api/Packages/get-package-video.php?id=" + packageID, false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

function getQuestionsInSelectedPackage() {
    var packageID = document.getElementById("select-package").value;
    var instructorID = 99;                                            // TODO: use session variable
    console.log("Getting all questions currently within the selected package.");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var res = JSON.parse(this.responseText);
            fillQuestionTable(res);
            placeMarkersOnVideo(res);
        }
    };
    xhttp.open("GET", "../api/videoquestions/get-questions-in-package.php?packageID=" + packageID + "&instructorID=" + instructorID, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

function fillQuestionTable(questions) {
    console.log(questions);
    console.log("Clearing question table...");
    var table = document.getElementById("ivc-add-questions-added-table");
    table.innerHTML = "<th colspan='3'>Questions in the Package</th>";
    console.log("Filling question table...");
    for (i = 0; i < questions.length; i++) {
        let tr = document.createElement("tr");
        tr.setAttribute("data-value", questions[i].ID);
        let td1 = document.createElement("td");
        let td2 = document.createElement("td");
        let td3 = document.createElement("td");
        let questionNode = document.createTextNode(questions[i].QuestionText);
        let stampNode = document.createTextNode(questions[i].TimeStamp);
        let inputNode = document.createElement("input");
        let updateButton = document.createElement("button");
        let deleteButton = document.createElement("button");
        let orText = document.createTextNode(" or ");
        updateButton.setAttribute("onclick", "tableRowUpdate(this)");
        updateButton.innerHTML = "Update";
        deleteButton.setAttribute("onclick", "tableRowDelete(this)");
        deleteButton.innerHTML = "Delete";
        td1.appendChild(questionNode);
        td2.appendChild(stampNode);
        td3.appendChild(inputNode);
        td3.appendChild(updateButton);
        td3.appendChild(orText);
        td3.appendChild(deleteButton);
        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        table.appendChild(tr);
    }
}

function tableRowUpdate(button) {
    console.log("tableRowUpdate() called.");
}

function tableRowDelete(button) {
    console.log("tableRowDelete() called.");
}

function placeMarkersOnVideo(questions) {
    var player = videojs('AddQuestions-video');
    var options = {};
    options.markers = [];
    var i;
    for (i = 0; i < questions.length; i++) {
        let timeStamp = questions[i].TimeStamp;
        let newMarker = {};
        newMarker.time = timeStamp;
        options.markers.push(newMarker);
        console.log(options);
    }
    player.markers.removeAll();
    player.markers.add(options.markers);
}