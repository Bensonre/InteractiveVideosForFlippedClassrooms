var form_error = "Please fill out all input fields";
var mainVideo = videojs("ivc-add-questions-player"); 
var combineComponentAllQuestions = [];                      /* Stores all questions retrieved from the server. */
var timestampInput = document.getElementById("timestamp");

/*
 * Adds the 'timeupdate' event listener to the video player as soon as it's ready.
 */
mainVideo.ready(function () {
        this.on('timeupdate', function() {
                var time = parseFloat(mainVideo.currentTime()).toFixed(1);
                timestampInput.value = formatTimestamp(time);
                timestampInput.setAttribute('time-value', time);
        })
});

/*
 * Initialize the marker plugin, get packages, and get questions on window load.
 */
window.onload = function() {
    initializeMarkerPlugin();
    getPackages();
    getQuestions();
}

/**
 * Initializes the marker plugin used to place markers on the video player.
 */
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

/**
 * Retrieves all of the packages for this instuctor and passes them to the 'fillPackages()' function.
 */
function getPackages() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var obj = JSON.parse(this.responseText);

            obj.sort((a, b) => {
                if (a.title.toLowerCase() < b.title.toLowerCase()) { return -1; }
                if (a.title.toLowerCase() > b.title.toLowerCase()) { return 1; }
                return 0;
            });

            fillPackages(obj);
        }
    };
    const getURL = `${ivcPathToSrc}api/Packages/read-all-with-instructor-id.php`;
    xhttp.open("GET", getURL, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

/**
 * Retrieves all of the questions for this instuctor and passes them to the 'fillQuestions()' function.
 */
function getQuestions() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var obj = JSON.parse(this.responseText);

            // Alphabetically sort the questions by the question text.
            obj.sort((a, b) => {
                if (a.questionText.toLowerCase() < b.questionText.toLowerCase()) { return -1; }
                if (a.questionText.toLowerCase() > b.questionText.toLowerCase()) { return 1; }
                return 0;
            });

            combineComponentAllQuestions = [...obj];

            fillFilterSelectionBox();
            fillQuestions(obj);
        }
    };
    const getURL = `${ivcPathToSrc}api/questions/read.php`;
    xhttp.open("GET", getURL, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

/**
 * This function is passed the packages that were received from the server.
 * 
 * @param obj The array of packages from the server.
 */
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

/**
 * This function is passed the questions that were received from the server.
 * 
 * @param obj The array of questions from the server.
 */
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

/**
 * Adds the currently selected question into the currently selected package at the current timestamp.
 */
function sendData() {
    var packageID = document.getElementById("select-package").value;
    var questionID = document.getElementById("select-question").value;
    var timestamp = formattedToSeconds(timestampInput.getAttribute("time-value"));

    if(!(packageID.length > 0) ||
       !(questionID.length > 0) ||
       !(timestamp.toString().length > 0)) {
            alert(form_error);
            return false;
    }

    var info = {"packageID":packageID, "questionID":questionID, "timestamp":timestamp};
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
    const postURL = `${ivcPathToSrc}api/packagequestions/create.php`;
    xhttp.open("POST", postURL, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + JSON.stringify(info));
}

/**
 * This function is called when the user selects a new package. The video for the new package is 
 * loaded into the player and the questions in the package are retrieved from the server.
 */
function packageChanged() {
    getVideo();
    getQuestionsInSelectedPackage();
}

/**
 * Retrieves the source of the video for the currently selected package from the server and 
 * loads it into the video player.
 */
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

/**
 * Retrieves all of the questions that are in the selected package from the server.
 * 
 * This function then passes them to functions 'fillQuestionTable()' and 'placeMarkersOnVideo()' to 
 * fill the question table and place markers on the video player.
 */
function getQuestionsInSelectedPackage() {
    var packageID = document.getElementById("select-package").value;

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
    const getURL = `${ivcPathToSrc}api/packagequestions/get-questions-in-package.php?packageID=${packageID}`;
    xhttp.open("GET", getURL, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

/**
 * Fills the question table with the given array of questions.
 * 
 * @param questions An array of questions that are within the currently selected package.
 */
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

/**
 * Converts a decimal timestamp into the string time format HH:MM:SS.
 * 
 * @param timestamp A timestamp in decimal form.
 */
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

/**
 * Handles allowing the user to update a timestamp without having to remove the 
 * question from the package.
 * 
 * @param button The update button being pressed.
 */
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
        const postURL = `${ivcPathToSrc}api/packagequestions/update.php`;
        xhttp.open("POST", postURL, false);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("id=" + id + "&timestamp=" + newTimestamp);
    }
}

/**
 * Converts a timestamp in string format HH:MM:SS into decimal form.
 * 
 * @param timestamp A timestamp in string format.
 */
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

/**
 * Handles allowing the user to remove a question from the package.
 * 
 * @param button The delete button being pressed.
 */
function tableRowDelete(button) {
    var row = button.parentNode.parentNode;
    var table = row.parentNode;
    var timestamp = row.childNodes[1].childNodes[0];
    if (timestamp.tagName == "DIV") {
        timestamp = formattedToSeconds(timestamp.getAttribute("time-value"));
    } else {
        timestamp = formattedToSeconds(timestamp.getAttribute("time-value"));
    }
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
    const postURL = `${ivcPathToSrc}api/packagequestions/delete.php`;
    xhttp.open("POST", postURL, false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("id=" + id);
}

/**
 * Removes the marker at the specified timestamp from the video player.
 * 
 * @param {*} timestamp The timestamp location of the marker to remove.
 */
function removeMarkerAtTimestamp(timestamp) {
    var player = videojs('ivc-add-questions-player');
    var markers = player.markers.getMarkers();
    for (let i = 0; i < markers.length; i++) {
        if (markers[i].time == timestamp) {
            player.markers.remove([i]);
        }
    }
}

/**
 * Places markers on the video player at the locations of the questions in the package.
 * 
 * @param {*} questions The questions in the package retrieved from the server.
 */
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

/**
 * Removes the 'timeupdate' event listener from the video player and pauses it.
 */
function timeFieldOnFocus() {
    mainVideo.off('timeupdate');
    mainVideo.pause();
}

/**
 * Adds the 'timeupdate' event listener to the video player.
 */
function timeFieldFocusOut() {
    mainVideo.currentTime(formattedToSeconds(timestampInput.value));

    mainVideo.on('timeupdate', function() {
        var time = parseFloat(mainVideo.currentTime()).toFixed(1);
        timestampInput.value = formatTimestamp(time);
        timestampInput.setAttribute('time-value', time);
    });
}

/**
 * Sets the timestamp input element attribute value used to store the timestamp 
 * when the user inputs a value.
 */
function timeFieldChanged() {
    timestampInput.setAttribute("time-value", timestampInput.value);
    mainVideo.currentTime(formattedToSeconds(timestampInput.value));
}

/**
 * Fills the filter selection box with all possible filters. 
 * 
 * The default filter is 'All' and the following filters are sorted alphabetically.
 */
function fillFilterSelectionBox() {
    const filterSelection = document.getElementById("ivc-combine-question-filter");
    const filterAllOption = document.createElement("option");
    filterAllOption.innerText = "All";
    filterSelection.appendChild(filterAllOption);

    let categoryFilteredQuestions = [...combineComponentAllQuestions];

    categoryFilteredQuestions.sort((a, b) => {
        return a.category.localeCompare(b.category);
    });

    categoryFilteredQuestions = combineComponentAllQuestions.filter((element, index, array) => {
        return index == array.findIndex((a) => {
            return a.category == element.category;
        });
    });

    for (let i = 0; i < categoryFilteredQuestions.length; i++) {
        const option = document.createElement("option");
        option.innerText = categoryFilteredQuestions[i].category;
        filterSelection.appendChild(option);
    }
}

/**
 * Triggered when the user selects a new filter.
 */
function combineFilterChanged() {
    fillFilteredQuestions();
}

/**
 * Fills the question selection box only with questions that match the currently selected filter.
 * If the filter is 'All', all questions are displayed.
 */
function fillFilteredQuestions() {
    const questionSelectionBox = document.getElementById("select-question");
    const filterSelection = document.getElementById("ivc-combine-question-filter");
    const currentFilter = filterSelection.options[filterSelection.selectedIndex].innerText;
    questionSelectionBox.innerHTML = "";

    let questions = combineComponentAllQuestions;
    for (let i = 0; i < questions.length; i++) {
        if (questions[i].category == currentFilter || currentFilter == "All") {
            let option = document.createElement("option");
            option.value = i;
            let text = document.createTextNode(questions[i].questionText);
            option.appendChild(text);
            questionSelectionBox.appendChild(option);
        }
    }
}