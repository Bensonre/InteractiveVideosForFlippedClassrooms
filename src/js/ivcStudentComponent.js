var ivcCurrentQuestion = 0;         /* The index used amongst only the unanswered questions. */
var ivcCurrentOverallQuestion = 0;  /* Keeps track of the overall position in the list of package questions. */
var ivcQuestionPositions = [];      /* Stores only the unanswered questions. */

const player = videojs('ivcStudentPlayer'); /* Needed by 'playerTimeUpdateFunc'. */

/**
 * Used to detect when the player has reached the next unanswered question.
 * 
 * When it does, it removes the event listener and then sticks the player. 
 * The function that sticks the player will re-add the removed event listener 
 * upon the user answering the question.
 */
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

/**
 * Sorts the overlays by their starting time and determines which have not yet 
 * been answered. 
 */
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

/**
 * Sticks the player at the location of the unanswered question until it is answered.
 * 
 * Once the question is answered, it will re-add the 'timeupdate' event listener used 
 * to monitor if the player has reached another unanswered question.
 * 
 * @param {*} player A reference to the student video player.
 * @param {*} currentQuestion The index of the current unanswered question.
 */
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

/**
 * Sets the the 'timeupdate' event listener used to monitor if the player has reached another unanswered question.
 * 
 * @param {*} player The student video player.
 */
function registerTimeListener(player) {
    player.on('timeupdate', playerTimeUpdateFunc);
}

/**
 * Initializes the student player.
 * 
 * Loads the video source, package title, and overlays.
 * 
 * @param {*} packageInfo Object containing the information associated with the package.
 * @param {*} overlays The overlays constructed by PHP that will be loaded into the VideoJS overlays plugin.
 */
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

/**
 * Fetches the answer provided by the user and sends it to the server.
 * 
 * Once the answer submission is successful, this function will increment the proper 
 * global variables and resume playing the video player. The player will no longer stick
 * at this location due to the update of the global variables.
 * 
 * @param {*} button The button within the form of the question card answered.
 */
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