# Senior Capstone Interactive Video For Flipped Classroom
### By Reese Benson, Devin Sather, and Timothy O'Rourke
 
## Overview
Our goal is to create an Interactive platform for students to be able to answer questions during lecture or supplemental video content that is released by their professor. The Professors conversely should be able to upload videos, create questions and assign those questions to time stamps within the video. This Repository and project is simply a demo or Code Spike in that process. This is the proof of concept that will later be implemented in the pre-existing System Concept Warehouse. Concept Warehouse is an online tool designed to:
-Share your experiences and contribute to the community
-Find, create, and share conceptual questions
-Collect student answers in a variety of ways
-Visualize results for class use and education research.
 
## Scope
Due to the fact we are simply a proof of concept our scope is more limited than it may appear our task in only the creation of questions, the insertion of said questions into videos, the upload of videos, and the ability for students to answer questions.

## How to Run

### Option 1) Live demo
To see a live demo, visit one of the links below.

http://web.engr.oregonstate.edu/~orourtim/Capstone/src/demo/Student.php?id=1   (most up to date)

http://web.engr.oregonstate.edu/~bensonre/Capstone/src/demo/UploadVideo.php 

### Option 2) Clone repository and run php project in xampp.
#### Windows
Here is a link to an article showing how to download and run a project in xampp: https://timetoprogram.com/run-php-project-xampp/

Clone the repsitory into C:\xampp\htdocs\InteractiveVideosForFlippedClassrooms.

Start Xampp Control Panel

In the apache row click start.

Navigate to Localhost/InteractiveVideosForFlippedClassrooms/src/

          
#### Mac
Download Xampp here https://www.apachefriends.org/download.html. Choose the latest version for Mac.

Once The dmg file is downloaded run it and install XAMPP in the Application folder. 
If you have installed it else where move it to the application folder upon completion.

Clone our repository into /Applications/XAMPP/htdocs.

Start the Manager-osx application found in /Applications/XAMPP.

Click on the Manage Servers tab.

Once in the Manage Servers tab, click on Apache Web Server. Then on the right side of the Application click Start.

When the Application has started running sucessfully the red dot next to Apache Web Server will become green. 

Navigate to localhost/InteractiveVideosForFlippedClassrooms/src
 
## UserCase:
###1)Professor
You will be acting as a professor creating a Package or a video enchanced with interactive questions.
1) Click instructor
2)Navigate to the upload video page via the instructor drop down menu and upload a video from your home computer or provide a youtube url.
3)Navigate to the Create Package page via the instructor drop down menu and select the vido you uplaoded along with a new title.
4)Navigate to the Create Questions page via the instructor drop down menu and create one or more questions.
5)Navigate to the Add Questions to Package page and Select the package you created and add the Question(s) you made to it at any time stamp you would like.

###2) Student
      You will now act as a student viewing the package you created as a professor.
      1) Click Sudent
      2) Click on Browse Packages
      3) Select the package you created above.
      4) Play the video and wait for the question you created to appear.
      5) The video should pause and your question should appear. Before Answering try to navigate past the question in the video. It should move the timeline back to where the question is so you can not skip it. 
      6) Answer the Question.
      7)The video should play again, rewind the video to the point in the time line where the question appeared. You should see it pop up with no option to submit and it shouldn't pause the video.
