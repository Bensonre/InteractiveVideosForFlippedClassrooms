var form_error = "Please fill out all input fields";

var ivcQuestionComponentQuestions = [];     /* Stores all of the questions retrieved from the server. */

/* On window load, retrieves the questions from the server. */
window.onload = function() {
    getQuestions();
}

/**
 * Creates a new question in the database using the form information given by the user.
 */
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

    document.getElementById("ivc-create-question-status-message").innerText = "Processing...";

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
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
    const postURL = `${ivcPathToSrc}api/questions/create.php`;
    xhttp.open("POST", postURL, false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + JSON.stringify(data));
}

/**
 * Updates the curretnly selected question in the database using the form information given by the user.
 */
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
    document.getElementById("ivc-update-question-status-message").innerText = "Processing...";

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
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
    const postURL = `${ivcPathToSrc}api/questions/update.php`;
    xhttp.open("POST", postURL, false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + JSON.stringify(data));
}

/**
 * Deletes the currently selected question from the database.
 */
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
    document.getElementById("ivc-delete-question-status-message").innerText = "Processing...";

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
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
    const postURL = `${ivcPathToSrc}api/questions/delete.php`;
    xhttp.open("POST", postURL, false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + JSON.stringify(data));
}

/**
 * Retrieves all of the questions that this user has created from the server.
 */
function getQuestions() {
    let instructorId = ivcInstructorId;

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            ivcQuestionComponentQuestions = JSON.parse(this.responseText);
            fillFilterSelectionBoxes();
            clearQuestionSelectionBoxes();
            fillQuestionSelectionBoxes();
            fillUpdateForm();
        }
    };
    const getURL = `${ivcPathToSrc}api/questions/read.php?instructorId=${instructorId}`;
    xhttp.open("GET", getURL, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

/**
 * Clears the question selection boxes on the update and delete tabs.
 */
function clearQuestionSelectionBoxes() {
    let updateSelectionBox = document.getElementById("ivc-question-select-update");
    let deleteSelectionBox = document.getElementById("ivc-question-select-delete");

    updateSelectionBox.innerHTML = "";
    deleteSelectionBox.innerHTML = "";
}

/**
 * Fills the question selection boxes on the update and delete tabs.
 */
function fillQuestionSelectionBoxes() {
    ivcQuestionComponentQuestions.sort((a, b) => {
        if (a.questionText.toLowerCase() < b.questionText.toLowerCase()) { return -1; }
        if (a.questionText.toLowerCase() > b.questionText.toLowerCase()) { return 1; }
        return 0;
    });

    let questions = ivcQuestionComponentQuestions;
    for (let i = 0; i < questions.length; i++) {
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

/**
 * Fills the update form with the associated information from the currently selected question.
 */
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

/**
 * Fills the filter selection boxes with all possible filters.
 */
function fillFilterSelectionBoxes() {
    let questions = [...ivcQuestionComponentQuestions];

    questions.sort((a, b) => {
        return a.category.localeCompare(b.category);
    });

    questions = questions.filter((element, index, array) => {
        return index == array.findIndex((a) => {
            return a.category == element.category;
        });
    });

    const filterUpdateSelection = document.getElementById("ivc-question-update-filter");
    const filterDeleteSelection = document.getElementById("ivc-question-delete-filter");
    filterUpdateSelection.innerHTML = "";
    filterDeleteSelection.innerHTML = "";
    const filterAllOption = document.createElement("option");
    filterAllOption.innerText = "All";
    filterUpdateSelection.appendChild(filterAllOption);
    filterDeleteSelection.appendChild(filterAllOption.cloneNode(true));
    for (let i = 0; i < questions.length; i++) {
        const option = document.createElement("option");
        option.innerText = questions[i].category;
        filterUpdateSelection.appendChild(option);
        filterDeleteSelection.appendChild(option.cloneNode(true));
    }
}

/**
 * Triggered when a new filter is selected on the update tab by the user.
 */
function updateFilterChanged() {
    fillUpdateQuestions();
    fillUpdateForm();
}

/**
 * Triggered when a new filter is selected on the delete tab by the user.
 */
function deleteFilterChanged() {
    fillDeleteQuestions();
}

/**
 * Fills the question selection box on the update tab using the currently selected filter.
 */
function fillUpdateQuestions() {
    const updateSelectionBox = document.getElementById("ivc-question-select-update");
    const filterUpdateSelection = document.getElementById("ivc-question-update-filter");
    const currentFilter = filterUpdateSelection.options[filterUpdateSelection.selectedIndex].innerText;
    updateSelectionBox.innerHTML = "";

    let questions = ivcQuestionComponentQuestions;
    for (let i = 0; i < questions.length; i++) {
        if (questions[i].category == currentFilter || currentFilter == "All") {
            let option = document.createElement("option");
            option.value = i;
            let text = document.createTextNode(questions[i].questionText);
            option.appendChild(text);
            updateSelectionBox.appendChild(option);
        }
    }
}

/**
 * Fills the question selection box on the delete tab using the currently selected filter.
 */
function fillDeleteQuestions() {
    const deleteSelectionBox = document.getElementById("ivc-question-select-delete");
    const filterDeleteSelection = document.getElementById("ivc-question-delete-filter");
    const currentFilter = filterDeleteSelection.options[filterDeleteSelection.selectedIndex].innerText;
    deleteSelectionBox.innerHTML = "";

    let questions = ivcQuestionComponentQuestions;
    for (let i = 0; i < questions.length; i++) {
        if (questions[i].category == currentFilter || currentFilter == "All") {
            let option = document.createElement("option");
            option.value = i;
            let text = document.createTextNode(questions[i].questionText);
            option.appendChild(text);
            deleteSelectionBox.appendChild(option);
        }
    }
}