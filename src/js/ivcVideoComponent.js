var form_error = "Please fill out all input fields";

var ivcVideoComponentVideos = [];

window.onload = function() {
    getVideos();
}

/**
 * Creates a new video in the database using the information provided by the user.
 */
function createVideo() {
    document.getElementById("ivc-create-video-status-message").innerText = "";

    let formData = new FormData();
    const ivcUploadProgress = document.getElementById("ivc-upload-progress");
    const fileInput = document.getElementById("ivc-video-select-create");
    const title = document.getElementById("ivc-video-title-create").value;
    const url = document.getElementById("ivc-video-link-create").value;

    if((!(fileInput.files.length > 0) && (url.length == 0)) ||
       !(title.length > 0)) {
            alert(form_error);
            return false;
    }

    if (fileInput.files && fileInput.files.length == 1) {
        const file = fileInput.files[0];
        const ext = file.name.match(/\.([^\.]+)$/)[1];
        switch (ext) {
        case 'mp4':
            break;
        default:
            alert('File type not allowed');
            return false;
        }    
        formData.set("local-video-file", file, file.name);

    } else {
        formData.append("link", url);
    }
    formData.append("title", title);

    formData.append(ivcUploadProgress.getAttribute("name"), ivcUploadProgress.getAttribute("value"));

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);

            if (res.success) {
                document.getElementById("uvideoform").reset();
            } else {
                toggleBarVisibility();
                document.getElementById("ivc-create-video-status-message").style.color = "red";
                document.getElementById("ivc-create-video-status-message").innerText = res.message;
            }

            getVideos();
        }
    };
    const postURL = `${ivcPathToSrc}api/videos/create.php`;
    xhttp.open("POST", postURL, true);
    xhttp.send(formData);

    startProgress();
}

/**
 * Updates the selected video using the information provided by the user.
 */
function updateVideo() {
    const videoIndex = document.getElementById("ivc-video-select-update").value;
    const id = ivcVideoComponentVideos[videoIndex].id;
    const title = document.getElementById("ivc-title-update").value;

    if(!(videoIndex.length > 0) ||
       !(title.length > 0)) {
            alert(form_error);
            return false;
    }

    const data = {
        "id": id,
        "title": title
    };

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            document.getElementById("ivc-update-video-status-message").innerText = res.message;

            if (res.success) {
                document.getElementById("ivc-update-video-status-message").style.color = "green";
                document.getElementById("upvideoform").reset();
                getVideos();
            } else {
                document.getElementById("ivc-update-video-status-message").style.color = "red";
            }

            getVideos();
        }
    };
    const postURL = `${ivcPathToSrc}api/videos/update.php`;
    xhttp.open("POST", postURL, false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('data=' + JSON.stringify(data));
}

/**
 * Deletes the selected video using the information provided by the user.
 */
function deleteVideo() {
    const videoIndex = document.getElementById("ivc-video-select-delete").value;
    const id = ivcVideoComponentVideos[videoIndex].id;
    const filePath = ivcVideoComponentVideos[videoIndex].filePath;

    if (!(videoIndex.length > 0)) {
            alert(form_error);
            return false;
    }

    const data = {
        "id": id,
        "filePath": filePath
    };

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var res = JSON.parse(this.responseText);
            document.getElementById("ivc-delete-video-status-message").innerText = res.message;

            if (res.success) {
                document.getElementById("ivc-delete-video-status-message").style.color = "green";
            } else {
                document.getElementById("ivc-delete-video-status-message").style.color = "red";
            }

            let updateOption = document.querySelector("#ivc-video-select-update option[value='" + videoIndex + "']");
            let deleteOption = document.querySelector("#ivc-video-select-delete option[value='" + videoIndex + "']");
            updateOption.remove();
            deleteOption.remove();
        }
    };
    const postURL = `${ivcPathToSrc}api/videos/delete.php`;
    xhttp.open("POST", postURL, false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('data=' + JSON.stringify(data));
}

/**
 * Retrieves all videos uploaded by this user.
 */
function getVideos() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            ivcVideoComponentVideos = JSON.parse(this.responseText);
            clearVideoSelectionBoxes();
            fillVideoSelectionBoxes();
        }
    };
    const getURL = `${ivcPathToSrc}api/videos/read-all-with-instructor-id.php`;
    xhttp.open("GET", getURL, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

/**
 * Clears the video selection boxes.
 */
function clearVideoSelectionBoxes() {
    let updateSelectionBox = document.getElementById("ivc-video-select-update");
    let deleteSelectionBox = document.getElementById("ivc-video-select-delete");

    updateSelectionBox.innerHTML = "";
    deleteSelectionBox.innerHTML = "";
}

/**
 * Fills the video selection boxes with the videos.
 */
function fillVideoSelectionBoxes() {
    ivcVideoComponentVideos.sort( (a, b) => {
        if (a.title.toLowerCase() > b.title.toLowerCase()) { return 1; } else { return 0; }
    } );
    const videos = ivcVideoComponentVideos;
    for (let i = 0; i < videos.length; i++) {
        let option = document.createElement("option");
        option.value = i;
        let text = document.createTextNode(videos[i].title);
        option.appendChild(text);
        let updateSelectionBox = document.getElementById("ivc-video-select-update");
        let deleteSelectionBox = document.getElementById("ivc-video-select-delete");
        let option2 = option.cloneNode(true);
        updateSelectionBox.appendChild(option);
        deleteSelectionBox.appendChild(option2);
    }
}

/**
 * Toggles visibility of the upload progress bar.
 */
function toggleBarVisibility() {
    var e = document.getElementById("ivc-progress-bar");
    let status = document.getElementById("ivc-progress-bar-status");
    e.style.display = (e.style.display == "block") ? "none" : "block";
    status.style.display = (status.style.display == "block") ? "none" : "block";
    document.getElementById("ivc-progress-bar-color").style.width = 0 + "%";
    document.getElementById("ivc-progress-bar-status").innerHTML = 0 + "%";
}

function createRequestObject() {
    var http;
    if (navigator.appName == "Microsoft Internet Explorer") {
        http = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else {
        http = new XMLHttpRequest();
    }
    return http;
}

/**
 * Requests the progress of the video upload from the server.
 */
function sendRequest() {
    var http = createRequestObject();
    const getURL = `${ivcPathToSrc}api/videos/progress.php`;
    http.open("GET", getURL, true);
    http.onreadystatechange = function () { handleResponse(http); };
    http.send(null);
}

/**
 * Handles updating the progress bar.
 * 
 * @param {*} http Response from 'progress.php'.
 */
function handleResponse(http) {
    var response;
    if (http.readyState == 4) {
        response = http.responseText;
        document.getElementById("ivc-progress-bar-color").style.width = response + "%";
        document.getElementById("ivc-progress-bar-status").innerHTML = response + "%";

        if (response < 100) {
            setTimeout("sendRequest()", 1000);
        }
        else {
            //toggleBarVisibility();
            document.getElementById("ivc-progress-bar-status").innerHTML = "Complete";
        }
    }
}

/**
 * Starts a loop that will query the server for progress on the current upload.
 */
function startProgress() {
    toggleBarVisibility();
    setTimeout("sendRequest()", 1000);
}
