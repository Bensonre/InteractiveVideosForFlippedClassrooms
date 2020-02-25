var mainVideo = document.getElementById("videoPlayer"); 
var input = document.getElementById("TimeStamp")

function updateVideoTime(){
    mainVideo.currentTime = input.value;
}

mainVideo.ontimeupdate = function(){
    input.value = mainVideo.currentTime;
  }