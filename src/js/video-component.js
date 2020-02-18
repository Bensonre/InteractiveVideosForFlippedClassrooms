var ivcVideoComponentVideos = [];

window.onload = function() {
    getVideos();
}

function createVideo() {
    let formData = new FormData();
    const fileInput = document.getElementById("ivc-video-select-create");
    const title = document.getElementById("ivc-video-title-create").value;
    const instructorId = ivcInstructorId;

    if (fileInput.files && fileInput.files.length == 1) {
        var file = fileInput.files[0];
        formData.set("local-video-file", file, file.name);
    }
    formData.append("title", title);
    formData.append("instructorId", instructorId);

    document.getElementById("ivc-create-video-status-message").innerText = "Processing...";

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var res = JSON.parse(this.responseText);
            document.getElementById("ivc-create-video-status-message").innerText = res.message;

            if (res.success) {
                document.getElementById("ivc-create-video-status-message").style.color = "green";
            } else {
                document.getElementById("ivc-create-video-status-message").style.color = "red";
            }
        }
    };
    xhttp.open("POST", "../api/videos/create.php", false);
    xhttp.send(formData);
}

function updateVideo() {
    const videoIndex = document.getElementById("ivc-video-select-update").value;
    const id = ivcVideoComponentVideos[videoIndex].id;
    const title = document.getElementById("ivc-title-update").value;

    const data = {
        "id": id,
        "title": title
    };

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var res = JSON.parse(this.responseText);
            document.getElementById("ivc-update-video-status-message").innerText = res.message;

            if (res.success) {
                document.getElementById("ivc-update-video-status-message").style.color = "green";
            } else {
                document.getElementById("ivc-update-video-status-message").style.color = "red";
            }
        }
    };
    xhttp.open("POST", "../api/videos/update.php", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send('data=' + JSON.stringify(data));
}

function getVideos() {
    const instructorId = ivcInstructorId;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            ivcVideoComponentVideos = JSON.parse(this.responseText);
            clearVideoSelectionBoxes();
            fillVideoSelectionBoxes();
        }
    };
    xhttp.open("GET", "../api/videos/get-instructor-videos.php?instructorId=" + instructorId, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

function clearVideoSelectionBoxes() {
    let updateSelectionBox = document.getElementById("ivc-video-select-update");
    let deleteSelectionBox = document.getElementById("ivc-video-select-delete");

    updateSelectionBox.innerHTML = "";
    deleteSelectionBox.innerHTML = "";
}

function fillVideoSelectionBoxes() {
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
