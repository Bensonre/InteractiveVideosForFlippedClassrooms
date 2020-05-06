var form_error = "Please fill out all input fields";
var mainVideo = videojs("ivc-add-questions-player"); 
var timestampInput = document.getElementById("timestamp");

//listener on ready state
mainVideo.ready(function () {
        this.on('timeupdate', function() {
                var time = parseFloat(mainVideo.currentTime()).toFixed(1);
                timestampInput.value = formatTimestamp(time);
                timestampInput.setAttribute('time-value', time);
        })
});

window.onload = function() {
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
    let instructorId = ivcInstructorId;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var obj = JSON.parse(this.responseText);
            fillPackages(obj);
        }
    };
    const getURL = `${ivcPathToSrc}api/Packages/read-all-with-instructor-id.php?instructorId=${instructorId}`;
    xhttp.open("GET", getURL, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

function getQuestions() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var obj = JSON.parse(this.responseText);
            fillQuestions(obj);
        }
    };
    const getURL = `${ivcPathToSrc}api/questions/read.php?instructorId=${ivcInstructorId}`;
    xhttp.open("GET", getURL, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

function fillPackages(obj) {
    var i;
    for (i = 0; i < obj.length; i++) {
        let option = document.createElement("option");
        option.value = obj[i].id;
        let text = document.createTextNode(obj[i].title);
        option.appendChild(text);
        let element = document.getElementById("select-package");
        element.appendChild(option);
    }
    packageChanged();
}

function fillQuestions(obj) {
    var i;
    for (i = 0; i < obj.length; i++) {
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
    var timestamp = formattedToSeconds(timestampInput.getAttribute("time-value"));
    let instructorID = ivcInstructorId;

    if(!(packageID.length > 0) ||
       !(questionID.length > 0) ||
       !(timestamp.toString().length > 0)) {
            alert(form_error);
            return false;
    }

    var info = {"packageID":packageID, "questionID":questionID, "instructorID":instructorID, "timestamp":timestamp};
    document.getElementById("ivc-add-questions-status-message").innerText = "Processing...";

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            document.getElementById("ivc-add-questions-status-message").innerText = res.message;

            if (res.success) {
                document.getElementById("ivc-add-questions-status-message").style.color = "green";
                getQuestionsInSelectedPackage();
            } else {
                document.getElementById("ivc-add-questions-status-message").style.color = "red";
            }
        }
    };
    const postURL = `${ivcPathToSrc}api/videoquestions/create.php`;
    xhttp.open("POST", postURL, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + JSON.stringify(info));
}

function packageChanged() {
    getVideo();
    getQuestionsInSelectedPackage();
}

function getVideo() {
    var packageID = document.getElementById("select-package").value;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            var player = videojs('ivc-add-questions-player');

            if (Number(res.isYouTube)) {
                player.src({src: `${res.filePath}`, type: 'video/youtube'});
            } else {
                player.src({src: `${ivcPathToSrc}/${res.filePath}`, type: 'video/mp4'});
            }
            player.play();
        }
    };
    const getURL = `${ivcPathToSrc}api/Packages/get-package-video.php?id=${packageID}`;
    xhttp.open("GET", getURL, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

function getQuestionsInSelectedPackage() {
    var packageID = document.getElementById("select-package").value;
    var instructorID = ivcInstructorId;                                         

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);

            res.sort(function (a, b) {
                    return a.timestamp - b.timestamp;
                }
            );

            fillQuestionTable(res);
            placeMarkersOnVideo(res);
        }
    };
    const getURL = `${ivcPathToSrc}api/videoquestions/get-questions-in-package.php?packageID=${packageID}&instructorID=${instructorID}`;
    xhttp.open("GET", getURL, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

function fillQuestionTable(questions) {
    const MAX_LENGTH = 400;
    var table = document.getElementById("ivc-add-questions-added-table");
    table.innerHTML = "";
    table.innerHTML += "<thead><th class='text-center'>Question</th><th class='text-center'>Timestamp</th>\
                            <th class='text-center'>Remove</th></thead>";
    
    for (i = 0; i < questions.length; i++) {
        let tr = document.createElement("tr");
        tr.setAttribute("data-value", questions[i].ID);
        let space = document.createTextNode("   ");
        let td1 = document.createElement("td");
        let td2 = document.createElement("td");
        let td3 = document.createElement("td");

        td1.style = "word-wrap: break-word;min-width: 52em;max-width: 52em;";
        td1.classList.add("text-center");
        td2.classList.add("text-center");
        td3.classList.add("text-center");
        td1.classList.add("align-middle");
        td2.classList.add("align-middle");
        td3.classList.add("align-middle");

        td1.innerText = questions[i].QuestionText.substring(0, MAX_LENGTH);
        if (questions[i].QuestionText.length > MAX_LENGTH) { td1.innerText += "..."; }

        let stampNode = document.createTextNode(formatTimestamp(questions[i].timestamp));
        let stampDiv = document.createElement("div");
        stampDiv.appendChild(stampNode);
        stampDiv.setAttribute("time-value", questions[i].timestamp);

        let updateButton = document.createElement("button");
        let deleteButton = document.createElement("button");
        updateButton.setAttribute("onclick", "tableRowUpdate(this)");
        updateButton.classList.add("btn");
        updateButton.classList.add("btn-warning");
        updateButton.innerHTML = "Update";
        deleteButton.setAttribute("onclick", "tableRowDelete(this)");
        deleteButton.classList.add("btn");
        deleteButton.classList.add("btn-danger");
        deleteButton.innerHTML = "Delete";

        td2.appendChild(stampDiv);
        td2.appendChild(space);
        td2.appendChild(updateButton);
        td3.appendChild(deleteButton);

        tr.appendChild(td1);
        tr.appendChild(td2);
        tr.appendChild(td3);
        table.appendChild(tr);
    }
    table.innerHTML += "</tbody>";
}

function formatTimestamp(timestamp) {
    timestamp = Number(timestamp);
    const hours = Math.floor(timestamp / 3600);
    const minutes = Math.floor((timestamp - (hours * 3600)) / 60);
    const seconds = Math.floor(timestamp - (hours * 3600) - (minutes * 60));

    let formattedTimestamp = "";
    if (hours > 0) { formattedTimestamp += hours + ":"}
    formattedTimestamp += minutes+":";
    formattedTimestamp += (seconds < 10 ? ("0" + seconds) : seconds);

    return formattedTimestamp;
}

function tableRowUpdate(button) {
    let timestampElement = button.parentNode.childNodes[0];
    const oldTimestamp = timestampElement.getAttribute("old-value");
    
    // Toggle the type of the element and button appearance.
    if (timestampElement.tagName == "DIV") {
        let newNode = document.createElement("input");
        newNode.value = timestampElement.innerText;
        newNode.setAttribute("old-value", newNode.value);
        newNode.setAttribute("time-value", timestampElement.getAttribute("time-value"));
        button.parentNode.replaceChild(newNode, timestampElement);
        button.classList.remove("btn-warning");
        button.classList.add("btn-primary");
        button.innerText = "Confirm";
    } else {
        // Submit the new updated timestamp.
        const row = button.parentNode.parentNode;
        let newNode = document.createElement("div");
        let newTimestamp = formattedToSeconds(timestampElement.value);
        newNode.setAttribute("time-value", newTimestamp);
        let id = row.getAttribute("data-value");

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var res = JSON.parse(this.responseText);
                if (res.success) {
                    getQuestionsInSelectedPackage();
                    newNode.innerText = timestampElement.value;
                } else {
                    newNode.innerText = oldTimestamp;
                }
                
                button.parentNode.replaceChild(newNode, timestampElement);
                button.classList.remove("btn-primary");
                button.classList.add("btn-warning");
                button.innerText = "Update";
            }
        };
        const postURL = `${ivcPathToSrc}api/videoquestions/update.php`;
        xhttp.open("POST", postURL, false);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id=" + id + "&timestamp=" + newTimestamp);
    }
}

function formattedToSeconds(timestamp) {
    const colonCount = (timestamp.match(/\:/g) || []).length;
    const sections = timestamp.split(':');
    let seconds = 0;

    if (colonCount == 0) {
        seconds = Number(timestamp);
    } else if (colonCount == 1) { 
        seconds = Number(parseInt(sections[0], 10) * 60) + Number(parseFloat(sections[1]));
    } else if (colonCount == 2) {
        seconds = Number(parseInt(sections[0], 10) * 3600) + Number(parseInt(sections[1], 10) * 60) + Number(parseFloat(sections[2]));
    }

    return seconds;
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
    var timestamp = row.childNodes[1].childNodes[0];
    if (timestamp.tagName == "DIV") {
        timestamp = formattedToSeconds(timestamp.getAttribute("time-value"));
    } else {
        timestamp = formattedToSeconds(timestamp.getAttribute("time-value"));
    }
    console.log(`timestamp: ${timestamp}`);
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
    const postURL = `${ivcPathToSrc}api/videoquestions/delete.php`;
    xhttp.open("POST", postURL, false);
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
    }
    player.markers.removeAll();
    player.markers.add(options.markers);
}

function timeFieldOnFocus() {
    mainVideo.off('timeupdate');
    mainVideo.pause();
}

function timeFieldFocusOut() {
    mainVideo.currentTime(formattedToSeconds(timestampInput.value));

    mainVideo.on('timeupdate', function() {
        var time = parseFloat(mainVideo.currentTime()).toFixed(1);
        timestampInput.value = formatTimestamp(time);
        timestampInput.setAttribute('time-value', time);
    });
}

function timeFieldChanged() {
    timestampInput.setAttribute("time-value", timestampInput.value);
    mainVideo.currentTime(formattedToSeconds(timestampInput.value));
}