var form_error = "Please fill out all input fields";

window.onload = function() {
   getVideos();
   getPackages();
}

function getVideos() {
   const instructorId = ivcInstructorId;
   let xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         const videos = JSON.parse(this.responseText);
         console.log(videos);
         fillVideos(videos);
      }
   };
   xhttp.open("GET", "../api/videos/read-all-with-instructor-id.php?instructorId=" + instructorId, true);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhttp.send();
}

function fillVideos(videos) {
   let element = document.getElementById("create-package-select-video");
   let element2 = document.getElementById("update-package-select-video");
   element.innerHTML = "";
   element2.innerHTML  = "";

   for (let i = 0; i < videos.length; i++) {
      let option = document.createElement("option");
      option.value = videos[i].id;
      option.setAttribute('video-path', videos[i].filePath);
      let text = document.createTextNode(videos[i].title);
      option.appendChild(text);
      let option2 = option.cloneNode(true);
      element.appendChild(option);
      element2.appendChild(option2);
   }
}

function createPackage() {
   const title = document.getElementById("create-package-title").value;
   const instructorId = ivcInstructorId;
   const videoId = document.getElementById("create-package-select-video").value;

   if(!(title.length > 0) ||
      !(videoId.length > 0)) 
   {
           alert(form_error);
           return false;
   }

   let data = {
      "title": title, 
      "instructorId": instructorId, 
      "videoId": videoId
   };

   document.getElementById("ivc-create-package-status-message").innerText = "Processing...";

   let xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         var res = JSON.parse(this.responseText);
         document.getElementById("ivc-create-package-status-message").innerText = res.message;

         if (res.success) {
               document.getElementById("ivc-create-package-status-message").style.color = "green";
         } else {
               document.getElementById("ivc-create-package-status-message").style.color = "red";
         }

         getPackages();
      }
   };
   xhttp.open("POST", "../api/Packages/create.php", false);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhttp.send("data=" + JSON.stringify(data));
}

function updatePackage() {
   const packageId = document.getElementById("update-package-selection").value;
   const title = document.getElementById("update-package-title").value;
   const instructorId = ivcInstructorId;
   const videoId = document.getElementById("update-package-select-video").value;
   
   if(!(title.length > 0) ||
      !(Number.isInteger(videoId)))
   { 
           alert(error_message)
           return false;
   }

   let data = {
      "packageId": packageId,
      "title": title, 
      "instructorId": instructorId, 
      "videoId": videoId 
   };

   document.getElementById("ivc-update-package-status-message").innerText = "Processing...";

   let xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         console.log(this.responseText);
         var res = JSON.parse(this.responseText);
         document.getElementById("ivc-update-package-status-message").innerText = res.message;

         if (res.success) {
               document.getElementById("ivc-update-package-status-message").style.color = "green";
         } else {
               document.getElementById("ivc-update-package-status-message").style.color = "red";
         }
      }
   };
   xhttp.open("POST", "../api/Packages/update.php", false);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhttp.send("data=" + JSON.stringify(data));
}

function deletePackage() {
   const packageId = document.getElementById("delete-package-selection").value;

   let data = {
      "packageId": packageId
   };

   document.getElementById("ivc-delete-package-status-message").innerText = "Processing...";

   let xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         var res = JSON.parse(this.responseText);
         document.getElementById("ivc-delete-package-status-message").innerText = res.message;

         if (res.success) {
               document.getElementById("ivc-delete-package-status-message").style.color = "green";
         } else {
               document.getElementById("ivc-delete-package-status-message").style.color = "red";
         }

         let updateOption = document.querySelector("#update-package-selection option[value='" + packageId + "']");
         let deleteOption = document.querySelector("#delete-package-selection option[value='" + packageId + "']");
         updateOption.remove();
         deleteOption.remove();
      }
   };
   xhttp.open("POST", "../api/Packages/delete.php", false);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhttp.send("data=" + JSON.stringify(data));
}

function getPackages() {
   const instructorId = ivcInstructorId;
   let xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         var packages = JSON.parse(this.responseText);
         fillPackages(packages);
      }
   };
   xhttp.open("GET", "../api/Packages/read-all-with-instructor-id.php?instructorId=" + instructorId, true);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhttp.send();
}

function fillPackages(packages) {
   packages.sort( (a, b) => {
      if (a.title.toLowerCase() > b.title.toLowerCase()) { return 1;} else { return 0; }
   } );

   let element = document.getElementById("update-package-selection");
   let element2 = document.getElementById("delete-package-selection");
   element.innerHTML = "";
   element2.innerHTML = "";
   for (let i = 0; i < packages.length; i++) {
      console.log(packages[i]);
      let option = document.createElement("option");
      option.S
      option.setAttribute('video-id', packages[i].videoId);
      option.value = packages[i].id;
      let text = document.createTextNode(packages[i].title);
      option.appendChild(text);
      let option2 = option.cloneNode(true);
      element.appendChild(option);
      element2.appendChild(option2);
   }
}

function updateCreatePackageVideoFilePath(){
   var selction = document.getElementById("create-package-select-video");
   var player = videojs("Create-Package-video");
   var path = selction.options[selction.selectedIndex].getAttribute("video-path");
   player.src(path);
   // set src track corresponding to new movie //
   player.load();
   player.play();
}

function updateUpdatePackageOnNewPackageSelected(){
    var packageTitle = document.getElementById("update-package-title");
    var packageSelection = document.getElementById("update-package-selection");
    var videoSelction = document.getElementById("update-package-select-video");
    packageTitle.value = packageSelection.options[packageSelection.selectedIndex].text;
    videoSelction.selectedIndex = Array.from(videoSelction.options).find(x=> x.value == packageSelection.options[packageSelection.selectedIndex].getAttribute('video-id')).index;
    updateUpdatePackageVideoFilePath();
 }

 function updateUpdatePackageVideoFilePath(){
    var videoSelction = document.getElementById("update-package-select-video");
    var player = videojs("Update-Package-video");
    var path = videoSelction.options[videoSelction.selectedIndex].getAttribute("video-path");
    player.src(path);
    // set src track corresponding to new movie //
    player.load();
    player.play();
 }
