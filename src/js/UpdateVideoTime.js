var mainVideo = videojs("ivc-add-questions-player"); 
var input = document.getElementById("timestamp");

//listener on ready state
mainVideo.ready(function () {
        this.on('timeupdate', function() {
                var time = parseFloat(mainVideo.currentTime()).toFixed(2);
                input.value = time.toString();
        })
});

function updateVideoTime(){
    mainVideo.currentTime(input.value);
    mainVideo.pause();
}

