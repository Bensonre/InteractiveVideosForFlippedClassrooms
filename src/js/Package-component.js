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