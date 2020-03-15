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

videojs('ivcStudentPlayer').on('timeupdate', () => {
        const player = videojs('ivcStudentPlayer');
        if (player.currentTime() > ivcQuestionPositions[ivcCurrentQuestion]) {
            player.currentTime(ivcQuestionPositions[ivcCurrentQuestion]);
            if (!player.paused()) {
                player.pause();
            }
        }
});

function initializeStudentPlayer(packageInfo, overlays) {
    let player = videojs('ivcStudentPlayer');
    player.reset();
    player.src(packageInfo.path);
    player.load();

    document.getElementById('packageTitle').innerText = packageInfo.title;

    player.overlay({
        overlays: overlays
    });
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