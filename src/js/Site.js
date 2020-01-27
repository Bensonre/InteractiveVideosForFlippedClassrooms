// This file is only used to test on layout.html not in any of the php
// Get the modal
 /*var modal = document.getElementById("grey-cover");
        
 
 // Get the <span> element that closes the modal
 var span = document.getElementsByClassName("close")[0];
 
 
 // When the user clicks the submit question button, open the modal 
 btn.onclick = function() {
   modal.style.display = "block";
 }
 
 // When the user clicks on <span> (x), close the modal
 span.onclick = function() {
   modal.style.display = "none";
 }*/
 
 // get video player
 // get time ints to display question
 var questionTimeStamps = [10,20, 40];
 var currentQuestion = 0;
 var mainVideo = document.getElementById("videoPlayer"); 
 var question = document.getElementById("Question-Modal");

 // Get the button that opens the modal
 var btn = document.getElementById("question-submit");


 //Navbar dropdown
 var dropdown = document.getElementById("drop-down");
 var instructor = document.getElementById("instr");


 //dropdown menu starts hidden
 dropdown.style.display = "none";

 //drop down menu on click effect
 instructor.onclick = function(){
	 if (dropdown.style.display === "none") {
		 dropdown.style.display = "inherit";
	 } else {
		 dropdown.style.display = "none";
	 }
 }

 //if window clicked closes dropdown
 /*
 window.onclick = function() {
		 dropdown.style.display = "none";
 }
 */
 function validateForm() {
	 var s1 = document.forms["f1"]["question"].value;
	 var s2 = document.forms["f1"]["category"].value;
	 var s3 = document.forms["f1"]["a1"].value;
	 var s4 = document.forms["f1"]["a2"].value;
	 var s5 = document.forms["f1"]["a3"].value;
	 var s6 = document.forms["f1"]["a4"].value;

	 if( s1 == "" || s2 == "" || s3 == "" || s4 == "" || s5 == "" || s6 == "") {
		 alert("There can't be any empty values");
		 return false;
	 }
 }


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




 // When the user clicks anywhere outside of the modal, close it
 /*window.onclick = function(event) {
   if (event.target == modal) {
     modal.style.display = "none";
   }
 
 }*/
