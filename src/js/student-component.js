window.onload = () => {
    getPackage();
};

function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

function getPackage() {
    let packageId = getUrlParameter('id');
    if (packageId === "") {packageId = 1;}

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            initializeStudentPlayer(JSON.parse(this.responseText));
        }
        else if (this.readyState == 4 && this.status != 200) {
            initializeStudentPlayer({});
        }
    };
    xhttp.open("GET", "../api/Packages/read-one.php?id=" + packageId, false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

function initializeStudentPlayer(package) {
    let player = videojs('ivcStudentPlayer');
    player.reset();
    player.src(package.Path);
    player.load();

    document.getElementById('packageTitle').innerText = package.Title;

    let overlays = [];

    for (let i = 0; i < package.Questions.length; i++) {
        overlays.push(constructOverlay(package.Questions[i]));
    }

    player.overlay({
        overlays: overlays
    });
}

function constructOverlay(question) {
    let overlay = {};

    overlay.start = Number(question.QuestionTimestamp);
    overlay.end = Number(overlay.start + 1);
    overlay.align = 'bottom-left';
    overlay.content = constructContent(question);

    return overlay;
}

function constructContent(question) {
    let content =  `<div class='container'><form>\
                        <h4 class='text-center'>${question.QuestionText}</h4>\
                        <div class='form-check'>\
                            <input class='form-check-input' type='radio' id='a1' name='answerOption' value='${question.Answer[0].Correct}'>\
                            <label class='form-check-label' for='a1'>${question.Answer[0].AnswerText}</label>\
                        </div>\
                        <div class='form-check'>\
                            <input class='form-check-input' type='radio' id='a2' name='answerOption' value='${question.Answer[1].Correct}'>\
                            <label class='form-check-label' for='a2'>${question.Answer[1].AnswerText}</label>\
                        </div>\
                        <div class='form-check'>\
                            <input class='form-check-input' type='radio' id='a3' name='answerOption' value='${question.Answer[2].Correct}'>\
                            <label class='form-check-label' for='a3'>${question.Answer[2].AnswerText}</label>\
                        </div>\
                        <div class='form-check'>\
                            <input class='form-check-input' type='radio' id='a4' name='answerOption' value='${question.Answer[3].Correct}'>\
                            <label class='form-check-label' for='a4'>${question.Answer[3].AnswerText}</label>\
                        </div>\
                        <button class='form-control mt-3 btn btn-primary' type='button' onclick='questionAnswered(this)'>Submit</button>\
                    </form></div>`;
    
    return content;
}

function questionAnswered(button) {
    button.disabled = true;
    const form = button.parentNode;
    const selection = form.querySelector('input[type=radio]:checked');
    if (selection) {
        const isCorrect = Number(selection.value);
        console.log('Question answered!');
        console.log(`Answer value: ${isCorrect}`);
        const feedbackNode = document.createElement('div');
        isCorrect ? feedbackNode.className += 'text-center text-success'
                  : feedbackNode.className += 'text-center text-danger';
        const feedbackTextNode = isCorrect ? document.createTextNode('Correct') 
                                           : document.createTextNode('Wrong');
        
        feedbackNode.appendChild(feedbackTextNode);
        form.removeChild(button);
        form.appendChild(feedbackNode);
    } else {
        button.disabled = false;
    }
}