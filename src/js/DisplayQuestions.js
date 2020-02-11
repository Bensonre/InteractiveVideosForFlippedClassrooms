
 
 // get video player
 // get time ints to display question
 var questions;
getquestions();
 function getquestions(){
  fetch('../api/Packages/read-one.php?id=1',
  {
    headers : { 
    'Content-Type': 'application/json',
    'Accept': 'application/json'
   }}
  )
  .then((response) => {
    return response.json();
  })
  .then((myJson) => {
    console.log(myJson);
    questions = myJson.Questions;
    questions.sort((a, b) => (a.QuestionTimestamp - b.QuestionTimestamp));
    console.log(questions)
  });
 // console.log(questions);
 // return questions;
}
 var currentQuestion = 0;
 var mainVideo = document.getElementById("videoPlayer"); 
 var question = document.getElementById("Question-Modal")

 // Get the button that opens the modal
 var btn = document.getElementById("question-submit");
 
 function SetNextQuestion(i){
    document.getElementById("question" +i).classList.add("hidden");
    if (++i < questions.length){
    document.getElementById("question" + i).classList.remove("hidden");
    }
 }
 
 window.addEventListener('load', function () {
   mainVideo = this.document.getElementById("videoPlayer_html5_api");
 mainVideo.ontimeupdate = function StopVideo(){
   if (currentQuestion < questions.length && mainVideo.currentTime >= questions[currentQuestion].QuestionTimestamp){
     mainVideo.currentTime = questions[currentQuestion].QuestionTimestamp;
     mainVideo.pause();
     question.style.display ="block";
     question.style.paddingLeft = mainVideo.currentTime/mainVideo.duration * 100 + "%";
   }
 }
})

 btn.onclick = function(){
    SetNextQuestion(currentQuestion);
   currentQuestion ++;
   question.style.display ="none";
   mainVideo.play();
 }
