var form_error = "Please fill out all input fields";

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
    
    //Form Validation for Creating Questions
    if(!(question.length > 0) ||
       !(category.length > 0) ||
       !(a1.length       > 0) ||
       !(a2.length       > 0) ||
       !(a3.length       > 0) ||
       !(a4.length       > 0) ||
       !(correct.length  > 0)) {
            alert(form_error);
            return false;
    }

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
                document.getElementById("cqform").reset();
                getQuestions();
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


    //Form Validation for Updatint Questions
    if(!(questionIndex.length > 0)  ||     
       !(question.length > 0) ||
       !(category.length > 0) ||
       !(a1.length       > 0) ||
       !(a2.length       > 0) ||
       !(a3.length       > 0) ||
       !(a4.length       > 0) ||
       !(correct.length  > 0)) {
            alert("All fields must be filled out");
            return false;
    }

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
                getQuestions();
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
    let questionIndex = document.getElementById("ivc-question-select-delete").value;
    let questionId = ivcQuestionComponentQuestions[questionIndex].questionId;

    if(!(questionIndex.length > 0)) {
            alert(form_error);
            return false;
    }

    let data = {
        "questionId":questionId,
    };
    console.log(JSON.stringify(data));
    document.getElementById("ivc-delete-question-status-message").innerText = "Processing...";

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            var res = JSON.parse(this.responseText);
            document.getElementById("ivc-delete-question-status-message").innerText = res.message;

            if (res.success) {
                document.getElementById("ivc-delete-question-status-message").style.color = "green";
            } else {
                document.getElementById("ivc-delete-question-status-message").style.color = "red";
            }

            let updateOption = document.querySelector("#ivc-question-select-update option[value='" + questionIndex + "']");
            let deleteOption = document.querySelector("#ivc-question-select-delete option[value='" + questionIndex + "']");
            updateOption.remove();
            deleteOption.remove();

            // Remove question from global array.
            ivcQuestionComponentQuestions.splice(questionIndex, 1);
        }
    };
    xhttp.open("POST", "../api/questions/delete.php", false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + JSON.stringify(data));
}

function getQuestions() {
    let instructorId = ivcInstructorId;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            ivcQuestionComponentQuestions = JSON.parse(this.responseText);
            console.log(ivcQuestionComponentQuestions);
            clearQuestionSelectionBoxes();
            fillQuestionSelectionBoxes();
            fillUpdateForm();
        }
    };
    xhttp.open("GET", "../api/questions/read.php?instructorId=" + instructorId, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

function clearQuestionSelectionBoxes() {
    let updateSelectionBox = document.getElementById("ivc-question-select-update");
    let deleteSelectionBox = document.getElementById("ivc-question-select-delete");

    updateSelectionBox.innerHTML = "";
    deleteSelectionBox.innerHTML = "";
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
        let updateSelectionBox = document.getElementById("ivc-question-select-update");
        let deleteSelectionBox = document.getElementById("ivc-question-select-delete");
        let option2 = option.cloneNode(true);
        updateSelectionBox.appendChild(option);
        deleteSelectionBox.appendChild(option2);
    }
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
