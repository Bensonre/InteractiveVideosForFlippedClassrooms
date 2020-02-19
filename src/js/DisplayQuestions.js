
 
//Code from https://davidwalsh.name/query-string-javascript
function getUrlParameter(name) {
  name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
  var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
  var results = regex.exec(location.search);
  return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
};

 // get video player
 // get time ints to display question
 const PackageId= getUrlParameter("id");
 const StudentID = 1;
 var questions;
getquestions();
 function getquestions(){
  fetch('../api/Packages/read-one.php?id=' + PackageId,
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
    questions.sort((a,b) => (a.QuestionTimestamp > b.QuestionTimestamp) ? 1 : ((b.QuestionTimestamp > a.QuestionTimestamp) ? -1 : 0));
    
    console.log(questions)
  });
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

function submitAnswer(){
  document.getElementById("question" +currentQuestion).submit();
  SetNextQuestion(currentQuestion);
  currentQuestion ++;
  question.style.display ="none";
  mainVideo.play();
}
