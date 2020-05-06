var ivcCurrentQuestion = 0;
var ivcCurrentOverallQuestion = 0;
var ivcQuestionPositions = [];

const player = videojs('ivcStudentPlayer');

var playerTimeUpdateFunc = () => {
    if (player.currentTime() > ivcQuestionPositions[ivcCurrentQuestion]) {
        player.off('timeupdate', playerTimeUpdateFunc);

        player.currentTime(ivcQuestionPositions[ivcCurrentQuestion] + 0.1);
        if (!player.paused()) {
            player.pause();
        }
        
        player.setTimeout(() => {stickPlayer(player, ivcCurrentQuestion)}, 100);
    }
};

window.onload = () => {
    ivcOverlays.sort((a, b) => {return a.start <= b.start ? -1 : 1});

    for (let i = 0; i < ivcOverlays.length; i++) {
        if (!ivcOverlays[i].answered) {
            ivcQuestionPositions.push(ivcOverlays[i].start);
        } else {
            ivcCurrentOverallQuestion++;
        }
    }

    initializeStudentPlayer(ivcPackageInfo, ivcOverlays);
};

function stickPlayer(player, currentQuestion) {
    if (currentQuestion < ivcCurrentQuestion) {
        registerTimeListener(player);
        return;
    }

    if (player.currentTime() > ivcQuestionPositions[ivcCurrentQuestion]) {
        if (!player.paused()) {
            player.pause();
        }
        player.currentTime(ivcQuestionPositions[ivcCurrentQuestion]);
    }

    player.setTimeout(() => {stickPlayer(player, currentQuestion)}, 100);
}

function registerTimeListener(player) {
    player.on('timeupdate', playerTimeUpdateFunc);
}

/* Old method of locking the player for questions. This method no longer worked when the YouTube plugin was
   utilized. */
/* function registerTimeListenerOld(player) {
    player.on('timeupdate', () => {
        console.log(`Current time ${player.currentTime()}; Qtime: ${ivcQuestionPositions[ivcCurrentQuestion]}`);
            if (player.currentTime() > ivcQuestionPositions[ivcCurrentQuestion]) {
                if (!player.paused()) {
                    player.pause();
                }
                player.currentTime(ivcQuestionPositions[ivcCurrentQuestion]);
            }
    });
} */

function initializeStudentPlayer(packageInfo, overlays) {
    const player = videojs('ivcStudentPlayer');

    if (Number(packageInfo.isYouTube)) {
        player.src({src: `${packageInfo.path}`, type: 'video/youtube'});
    } else {
        player.src({src: `${ivcPathToSrc}/${packageInfo.path}`, type: 'video/mp4'});
    }

    player.ready( () => {
        registerTimeListener(player);
    }, true);

    document.getElementById('packageTitle').innerText = packageInfo.title;

    player.overlay({
        overlays: overlays
    });

    player.play();
}

function questionAnswered(button) {
    button.disabled = true;
    const form = button.parentNode;
    form.querySelector('input[type=radio]:checked').setAttribute('checked', true);
    const selection = form.querySelector('input[type=radio]:checked');
    if (selection) {
        const questionId = Number(form.querySelector('#questionId').getAttribute('data-value'));
        const answerId = Number(selection.value);
        const studentId = ivcStudentId;
        const packageId = ivcPackageId;

        const data = {
            studentId,
            questionId,
            answerId,
            packageId
        };

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                if (JSON.parse(this.responseText).success) {
                    form.removeChild(button);

                    ivcOverlays[ivcCurrentOverallQuestion].content = `${form.parentNode.parentNode.innerHTML}`;
                    videojs("ivcStudentPlayer").overlay({
                        overlays: ivcOverlays
                    });
                    ivcCurrentQuestion++;
                    ivcCurrentOverallQuestion++;
                    videojs("ivcStudentPlayer").play();
                } else {
                    button.disabled = false;
                }
            }
        };
        const postURL = `${ivcPathToSrc}api/answers/create.php`;
        xhttp.open("POST", postURL, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("data=" + JSON.stringify(data));

    } else {
        button.disabled = false;
    }
}