var ivcCurrentQuestion = 0;
var ivcQuestionPositions = [];

window.onload = () => {
    ivcOverlays.sort((a, b) => {return a.start <= b.start ? -1 : 1});

    for (let i = 0; i < ivcOverlays.length; i++) {
        if (!ivcOverlays[i].answered) {
            ivcQuestionPositions.push(ivcOverlays[i].start);
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
    player.on('timeupdate', () => {
        if (player.currentTime() > ivcQuestionPositions[ivcCurrentQuestion]) {
            player.off('timeupdate');

            if (!player.paused()) {
                player.pause();
            }
            player.currentTime(ivcQuestionPositions[ivcCurrentQuestion]);

            player.setTimeout(() => {stickPlayer(player, ivcCurrentQuestion)}, 100);
        }
    });
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
                console.log(this.responseText);
                if (JSON.parse(this.responseText).success) {
                    console.log("Answer submitted!");
                    form.removeChild(button);
                    ivcCurrentQuestion++;
                    videojs("ivcStudentPlayer").play();
                } else {
                    console.log("Answer not submitted!");
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