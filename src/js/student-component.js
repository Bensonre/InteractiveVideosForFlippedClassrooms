var ivcCurrentQuestion = 0;
var ivcQuestionPositions = [];

window.onload = () => {
    console.log(ivcPackageInfo);
    ivcOverlays.sort((a, b) => {return a.start <= b.start ? -1 : 1});
    console.log(ivcOverlays);

    for (let i = 0; i < ivcOverlays.length; i++) {
        ivcQuestionPositions[i] = ivcOverlays[i].start;
    }

    console.log(`Current question: ${ivcCurrentQuestion}`);
    console.log(`Question positions: ${ivcQuestionPositions}`);

    initializeStudentPlayer(ivcPackageInfo, ivcOverlays);
};

videojs('ivcStudentPlayer').on('timeupdate', () => {
        const player = videojs('ivcStudentPlayer');
        if (player.currentTime() >= ivcQuestionPositions[ivcCurrentQuestion]) {
            player.currentTime(ivcQuestionPositions[ivcCurrentQuestion]);
            player.pause();
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
        const questionId = form.querySelector('#questionId').getAttribute('data-value');
        const answerId = Number(selection.value);
        const studentId = ivcStudentId;
        console.log('Question answered!');
        console.log(`Question id: ${questionId}`);
        console.log(`Answer id: ${answerId}`);
        console.log(`Student id: ${studentId}`);

        const data = {
            studentId,
            questionId,
            answerId
        };

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
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
        xhttp.open("POST", "../api/answers/create.php", false);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("data=" + JSON.stringify(data));

    } else {
        button.disabled = false;
    }
}