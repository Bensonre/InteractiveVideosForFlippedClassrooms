window.onload = function() {
    console.log("Getting packages and questions...");
    initializeMarkerPlugin();
    getPackages();
    getQuestions();
}

function initializeMarkerPlugin() {
    var player = videojs('ivc-add-questions-player');
    player.markers({
        markerTip:{
            display: true,
            text: function(marker) {
            return marker.text;
            },
            time: function(marker) {
            return marker.time;
            }
        }
    });
}

function getPackages() {
    let instructorID = ivcInstructorId;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var obj = JSON.parse(this.responseText);
            console.log("Packages received...");
            fillPackages(obj);
        }
    };
    xhttp.open("GET", "../api/Packages/read-all-with-instructor-id.php?instructorId=" + instructorID, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
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
    let instructorID = ivcInstructorId;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var obj = JSON.parse(this.responseText);
            console.log("Questions received...");
            fillQuestions(obj);
        }
    };
    xhttp.open("GET", "../api/questions/read.php?instructorId=" + instructorID, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

function fillQuestions(obj) {
    console.log("Filling questions...");
    var i;
    for (i = 0; i < obj.length; i++) {
        console.log(obj[i]);
        let option = document.createElement("option");
        option.value = obj[i].questionId;
        let text = document.createTextNode(obj[i].questionText);
        option.appendChild(text);
        let element = document.getElementById("select-question");
        element.appendChild(option);
    }
}

function sendData() {
    var packageID = document.getElementById("select-package").value;
    var questionID = document.getElementById("select-question").value;
    var timestamp = document.getElementById("timestamp").value;
    let instructorID = ivcInstructorId;

    var info = {"packageID":packageID, "questionID":questionID, "instructorID":instructorID, "timestamp":timestamp};
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
            var player = videojs('ivc-add-questions-player');
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
    var instructorID = ivcInstructorId;                                         
    console.log("Getting all questions currently within the selected package.");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var res = JSON.parse(this.responseText);
            res.sort(function (a, b) {
                    if (a.timestamp > b.timestamp) return 1;
                    if (b.timestamp > a.timestamp) return -1;
                    return 0;
                }
            );
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
    table.innerHTML = "<thead class='text-center'>";
    table.innerHTML = "<tr><th colspan='3'>Questions in the Package</th></tr>";
    table.innerHTML += "<tr><th>Question</th><th>Timestamp</th><th>Options</th></tr>";
    table.innerHTML += "</thead>";
    console.log("Filling question table...");
    for (i = 0; i < questions.length; i++) {
        let tr = document.createElement("tr");
        tr.setAttribute("data-value", questions[i].ID);
        let space = document.createTextNode(" ");
        let td1 = document.createElement("td");
        let td2 = document.createElement("td");
        let td3 = document.createElement("td");
        let questionNode = document.createTextNode(questions[i].QuestionText);
        let stampNode = document.createTextNode(questions[i].timestamp);
        let inputNode = document.createElement("input");
        inputNode.type = "text";
        inputNode.style = "width: 4vw;";
        let updateButton = document.createElement("button");
        let deleteButton = document.createElement("button");
        let orText = document.createTextNode(" or ");
        updateButton.setAttribute("onclick", "tableRowUpdate(this)");
        updateButton.classList.add("btn");
        updateButton.classList.add("btn-warning");
        updateButton.innerHTML = "Update";
        deleteButton.setAttribute("onclick", "tableRowDelete(this)");
        deleteButton.classList.add("btn");
        deleteButton.classList.add("btn-danger");
        deleteButton.innerHTML = "Delete";
        td1.appendChild(questionNode);
        td2.appendChild(stampNode);
        td3.appendChild(inputNode);
        td3.appendChild(space);
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
    var row = button.parentNode.parentNode;
    var timestampNode = row.childNodes[1];
    var oldTimestamp = timestampNode.innerText;
    var newTimestamp = row.childNodes[2].childNodes[0].value;
    let id = row.getAttribute("data-value");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            if (res.success) {
                timestampNode.innerText = newTimestamp;
                updateMarkerAtTimestamp(oldTimestamp, newTimestamp);
            }
        }
    };
    xhttp.open("POST", "../api/videoquestions/update.php", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + id + "&timestamp=" + newTimestamp);
}

function updateMarkerAtTimestamp(oldTimestamp, newTimestamp) {
    var player = videojs('ivc-add-questions-player');
    var markers = player.markers.getMarkers();
    for (let i = 0; i < markers.length; i++) {
        if (markers[i].time == oldTimestamp) {
            markers[i].time = newTimestamp;
            break;
        }
    }
    player.markers.updateTime();
}

function tableRowDelete(button) {
    var row = button.parentNode.parentNode;
    var table = row.parentNode;
    var timestamp = row.childNodes[1].innerText;
    let id = row.getAttribute("data-value");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            if (res.success) {
                table.removeChild(row);
                removeMarkerAtTimestamp(timestamp);
            }
        }
    };
    xhttp.open("POST", "../api/videoquestions/delete.php", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + id);
}

function removeMarkerAtTimestamp(timestamp) {
    var player = videojs('ivc-add-questions-player');
    var markers = player.markers.getMarkers();
    for (let i = 0; i < markers.length; i++) {
        if (markers[i].time == timestamp) {
            player.markers.remove([i]);
        }
    }
}

function placeMarkersOnVideo(questions) {
    var player = videojs('ivc-add-questions-player');
    var options = {};
    options.markers = [];
    var i;
    for (i = 0; i < questions.length; i++) {
        let timestamp = questions[i].timestamp;
        let questionText = questions[i].QuestionText;
        let newMarker = {};
        newMarker.time = timestamp;
        newMarker.text = questionText;
        options.markers.push(newMarker);
        console.log(options);
    }
    player.markers.removeAll();
    player.markers.add(options.markers);
}