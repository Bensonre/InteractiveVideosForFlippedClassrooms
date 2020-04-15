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
   const getURL = `${ivcPathToSrc}api/videos/read-all-with-instructor-id.php?instructorId=${instructorId}`;
   xhttp.open("GET", getURL, true);
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
      option.setAttribute('isYouTube', videos[i].isYouTube);
      let text = document.createTextNode(videos[i].title);
      option.appendChild(text);
      let option2 = option.cloneNode(true);
      element.appendChild(option);
      element2.appendChild(option2);
   }

   updateCreatePackageVideoFilePath();
   updateUpdatePackageVideoFilePath();
}

function createPackage() {
   const title = document.getElementById("create-package-title").value;
   const instructorId = ivcInstructorId;
   const videoId = document.getElementById("create-package-select-video").value;
   
   //form validation
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
               document.getElementById("cpackageform").reset();
         } else {
               document.getElementById("ivc-create-package-status-message").style.color = "red";
         }

         getPackages();
      }
   };
   const postURL = `${ivcPathToSrc}api/Packages/create.php`;
   xhttp.open("POST", postURL, false);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhttp.send("data=" + JSON.stringify(data));
}

function updatePackage() {
   const packageId = document.getElementById("update-package-selection").value;
   const title = document.getElementById("update-package-title").value;
   const instructorId = ivcInstructorId;
   const videoId = document.getElementById("update-package-select-video").value;
  
   //form validation
   if(!(title.length > 0)     ||
      !(packageId.length > 0) ||
      !(videoId.length > 0))
   { 
           alert(form_error)
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
               document.getElementById("uppackageform").reset();
               getPackages();
         } else {
               document.getElementById("ivc-update-package-status-message").style.color = "red";
         }
      }
   };
   const postURL = `${ivcPathToSrc}api/Packages/Update.php`;
   xhttp.open("POST", postURL, false);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhttp.send("data=" + JSON.stringify(data));
}

function duplicatePackage(){
   const oldId = document.getElementById('duplicate-package-selection').value;
   const newTitle = document.getElementById('duplicate-package-title').value;
   const instructorId = ivcInstructorId;
   let data = {
      "oldPackageId": oldId,
      "newTitle": newTitle, 
      "instructorId": instructorId, 
   };
   let xhttp = new XMLHttpRequest();
   xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
         console.log(this.responseText);
         var res = JSON.parse(this.responseText);
         document.getElementById("ivc-duplicate-package-status-message").innerText = res.message;
         if (res.success) {
               document.getElementById("ivc-duplicate-package-status-message").style.color = "green";
         } else {
               document.getElementById("ivc-duplicate-package-status-message").style.color = "red";
         }
      }
   };
   const postURL = `${ivcPathToSrc}api/Packages/Duplicate.php`;
   xhttp.open("POST", postURL, false);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhttp.send("data=" + JSON.stringify(data));
}

function deletePackage() {
   
   const packageId = document.getElementById("delete-package-selection").value;
   
   //form validation
   if(!(packageId.length > 0))
   {
           alert(form_error);
           return false;
   }

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
   const postURL = `${ivcPathToSrc}api/Packages/Delete.php`;
   xhttp.open("POST", postURL, false);
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
   const getURL = `${ivcPathToSrc}api/Packages/read-all-with-instructor-id.php?instructorId=${instructorId}`;
   xhttp.open("GET", getURL, true);
   xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xhttp.send();
}

function fillPackages(packages) {
   packages.sort( (a, b) => {
      if (a.title.toLowerCase() > b.title.toLowerCase()) { return 1;} else { return 0; }
   } );

   let element = document.getElementById("update-package-selection");
   let element2 = document.getElementById("delete-package-selection");
   let element3 = document.getElementById("duplicate-package-selection");
   element.innerHTML = "";
   element2.innerHTML = "";
   element3.innerHTML ="";
   for (let i = 0; i < packages.length; i++) {
      console.log(packages[i]);
      let option = document.createElement("option");
      option.S
      option.setAttribute('video-id', packages[i].videoId);
      option.value = packages[i].id;
      let text = document.createTextNode(packages[i].title);
      option.appendChild(text);
      let option2 = option.cloneNode(true);
      let option3 = option.cloneNode(true);
      element.appendChild(option);
      element2.appendChild(option2);
      element3.appendChild(option3);
   }
}

function updateCreatePackageVideoFilePath(){
   const selection = document.getElementById("create-package-select-video");
   const player = videojs("Create-Package-video");
   const path = selection.options[selection.selectedIndex].getAttribute("video-path");
   const isYouTube = selection.options[selection.selectedIndex].getAttribute("isYouTube");

   if (Number(isYouTube)) {
      player.src({src: `${path}`, type: 'video/youtube'});
   } else {
      player.src({src: `${ivcPathToSrc}/${path}`, type: 'video/mp4'});
   }
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
    player.src(`${ivcPathToSrc}/${path}`);
    // set src track corresponding to new movie //
    player.load();
    player.play();
 }


