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