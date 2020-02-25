var mainVideo = videojs("ivc-add-questions-player"); 
var input = document.getElementById("timestamp");

//listener on ready state
mainVideo.ready(function () {
        this.on('timeupdate', function() {
                var time = parseFloat(mainVideo.currentTime()).toFixed(1);
                input.value = time.toString();
        })
});

function updateVideoTime(){
    mainVideo.currentTime(input.value);
    mainVideo.pause();
}

document.onkeydown = function(e) {
        if(e.keyCode == 37) { 
                mainVideo.currentTime(mainVideo.currentTime() - .1)
        }
        if(e.keyCode == 39) {
                mainVideo.currentTime(mainVideo.currentTime() + .1)
        }
}
