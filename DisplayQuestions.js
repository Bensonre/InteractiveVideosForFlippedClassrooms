
 
 // get video player
 // get time ints to display question
 var questionTimeStamps = [10,20, 40];
 var currentQuestion = 0;
 var mainVideo = document.getElementById("videoPlayer"); 
 var question = document.getElementById("Question-Modal")

 // Get the button that opens the modal
 var btn = document.getElementById("question-submit");
 
 

 mainVideo.ontimeupdate = function(){
   if (mainVideo.currentTime >= questionTimeStamps[currentQuestion]){
     mainVideo.currentTime = questionTimeStamps[currentQuestion];
     mainVideo.pause();
     question.style.display ="block";
     question.style.paddingLeft = mainVideo.currentTime/mainVideo.duration * 100 + "%";
   }
 }

 btn.onclick = function(){
   currentQuestion ++;
   if(currentQuestion >= questionTimeStamps.length){
       questionTimeStamps.push(mainVideo.duration+1);
   }
   question.style.display ="none";
   mainVideo.play();
 }