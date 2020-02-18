function createVideo() {
    let formData = new FormData();
    const fileInput = document.getElementById("ivc-video-select-create");
    const title = document.getElementById("ivc-video-title-create").value;

    if (fileInput.files && fileInput.files.length == 1) {
        var file = fileInput.files[0];
        formData.set("local-video-file", file, file.name);
    }
    formData.append("title", title);

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