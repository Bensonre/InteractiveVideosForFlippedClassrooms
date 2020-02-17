var ivcQuestionComponentQuestions = [];

window.onload = function() {
    getQuestions();
}

function createQuestion() {
    let question = document.getElementById("ivc-question").value;
    let category = document.getElementById("ivc-category").value;
    let a1 = document.getElementById("ivc-a1").value;
    let a2 = document.getElementById("ivc-a2").value;
    let a3 = document.getElementById("ivc-a3").value;
    let a4 = document.getElementById("ivc-a4").value;
    let correct = document.getElementById("ivc-select-answer").value;
    let instructorId = ivcInstructorId;

    let data = {
        "question":question, 
        "category":category, 
        "a1":a1, 
        "a2":a2,
        "a3":a3,
        "a4":a4,
        "correct":correct,
        "instructorId":instructorId
    };
    console.log(JSON.stringify(data));
    document.getElementById("ivc-create-question-status-message").innerText = "Processing...";

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var res = JSON.parse(this.responseText);
            document.getElementById("ivc-create-question-status-message").innerText = res.message;

            if (res.success) {
                document.getElementById("ivc-create-question-status-message").style.color = "green";
            } else {
                document.getElementById("ivc-create-question-status-message").style.color = "red";
            }
        }
    };
    xhttp.open("POST", "../api/questions/create.php", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + JSON.stringify(data));
}

function updateQuestion() {
    let questionIndex = document.getElementById("ivc-question-select-update").value;
    let questionId = ivcQuestionComponentQuestions[questionIndex].questionId;
    let question = ivcQuestionComponentQuestions[questionIndex].questionText;
    let category = document.getElementById("ivc-category-update").value;
    let a1 = document.getElementById("ivc-a1-update").value;
    let a2 = document.getElementById("ivc-a2-update").value;
    let a3 = document.getElementById("ivc-a3-update").value;
    let a4 = document.getElementById("ivc-a4-update").value;
    let correct = document.getElementById("ivc-select-answer-update").value;
    let instructorId = ivcInstructorId;

    let data = {
        "questionId":questionId,
        "question":question, 
        "category":category, 
        "a1":a1, 
        "a2":a2,
        "a3":a3,
        "a4":a4,
        "correct":correct,
        "instructorId":instructorId
    };
    console.log(JSON.stringify(data));
    document.getElementById("ivc-update-question-status-message").innerText = "Processing...";

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var res = JSON.parse(this.responseText);
            document.getElementById("ivc-update-question-status-message").innerText = res.message;

            if (res.success) {
                document.getElementById("ivc-update-question-status-message").style.color = "green";
            } else {
                document.getElementById("ivc-update-question-status-message").style.color = "red";
            }
        }
    };
    xhttp.open("POST", "../api/questions/update.php", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + JSON.stringify(data));
}

function deleteQuestion() {

}

function getQuestions() {
    let instructorId = ivcInstructorId;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            ivcQuestionComponentQuestions = JSON.parse(this.responseText);
            console.log(ivcQuestionComponentQuestions);
            fillQuestionSelectionBoxes();
        }
    };
    xhttp.open("GET", "../api/questions/read.php?instructorId=" + instructorId, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

function fillQuestionSelectionBoxes() {
    let questions = ivcQuestionComponentQuestions;
    console.log(questions);
    for (let i = 0; i < questions.length; i++) {
        console.log(questions[i]);
        let option = document.createElement("option");
        option.value = i;
        let text = document.createTextNode(questions[i].questionText);
        option.appendChild(text);
        let element = document.getElementById("ivc-question-select-update");
        element.appendChild(option);
    }
    fillUpdateForm();
}

function fillUpdateForm() {
    let questionIndex = document.getElementById("ivc-question-select-update").value;
    let question = ivcQuestionComponentQuestions[questionIndex];

    document.getElementById("ivc-category-update").value = question.category;
    document.getElementById("ivc-a1-update").value = question.answers[0].answerText;
    document.getElementById("ivc-a2-update").value = question.answers[1].answerText;
    document.getElementById("ivc-a3-update").value = question.answers[2].answerText;
    document.getElementById("ivc-a4-update").value = question.answers[3].answerText;

    for (let i = 0; i < question.answers.length; i++) {
        if (question.answers[i].correct === 1) {
            document.getElementById("ivc-select-answer-update").value = i + 1;
        }
    }
}