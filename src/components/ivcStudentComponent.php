<?php
    include_once '../database/Database.php';
    include_once '../controllers/PackagesController.php';
    include_once '../controllers/AnswerController.php';
    include_once '../session_variables/session_variables.php';
    $database = new Database();
    $db = $database->connect();
      
    $controller = new PackageController($db);
    if (empty($_GET["id"])){        
        echo "No package id was provided.";
    } else {
        $packageId = intval($_GET['id']);
        $res = $controller->getPackageWithVideo($packageId);

        if (empty($res['Path'])) { 
            echo "INVALID PACKAGE ID"; 
        } else {
            // Create package info
            $packageInfo = array("path" => $res['Path'], "isYouTube" => $res['IsYouTube'], "title" => $res['Title']);

            // Get questions already answered in this package by the student
            $answerController = new AnswerController($db);
            $alreadyAnsweredQuestions = $answerController->readAnsweredQuestions($packageId, $ivcStudentId);

            $alreadyAnswered = array();
            foreach ($alreadyAnsweredQuestions as $obj) {
                array_push($alreadyAnswered, $obj);
            }

            foreach ($res['Questions'] as &$question) {
                $question['answered'] = false;
                $question['choice'] = null;
            }

            foreach ($alreadyAnsweredQuestions['Questions'] as &$alreadyAnsweredQuestion) {
                foreach($res['Questions'] as &$question) {
                    if ($question['QuestionID'] == $alreadyAnsweredQuestion['QuestionID']) {
                        $question['answered'] = true;
                        $question['choice'] = $alreadyAnsweredQuestion['ChoiceID'];
                    }
                }
            }

            // Create the overlays
            $overlays = array();

            for ($i = 0; $i < count($res['Questions']); $i++) {
                array_push($overlays, constructOverlay($res['Questions'][$i]));
            }
        }
    }
?>

<script>
    var ivcPackageInfo = <?php echo json_encode($packageInfo); ?>;
    var ivcOverlays = <?php echo json_encode($overlays); ?>;
    var ivcPackageId = <?php echo json_encode($packageId); ?>;
    var ivcAlreadyAnswered = <?php echo json_encode($alreadyAnsweredQuestions); ?>;
</script>

<div class="container">
    <h1 id="packageTitle" class="text-center"></h1>
	<div>
        <video
        id="ivcStudentPlayer"
        class="video-js vjs-default-skin vjs-16-9"
        controls 
        data-setup='{ "techOrder": ["youtube", "html5"] }'>
        <source id="student-video-source" src="?" type="video/mp4">
        </video>
    </div>
</div>

<?php
    function constructOverlay($question) {
        $overlay = array("start" => floatval($question['QuestionTimestamp']), "end" => $question['QuestionTimestamp'] + 1.0,
            "align" => "bottom-left", "content" => constructContent($question), "answered" => $question['answered']
        );
    
        return $overlay;
    }
    
    function constructContent($question) {
        $content =  "<div class='container'><form>
                            <div id='questionId' data-value='". $question['QuestionID'] ."' hidden></div>
                            <h4 class='text-center'>". $question['QuestionText'] . "</h4>
                            <div class='form-check'>
                                <input class='form-check-input' type='radio' name='answerOption' value='". $question['Answer'][0]['AnswerID'] . "'". ($question['Answer'][0]['AnswerID'] == $question['choice'] ? ' checked' : '') .">
                                <label class='form-check-label' for='a1'>". $question['Answer'][0]['AnswerText'] . "</label>
                            </div>
                            <div class='form-check'>
                                <input class='form-check-input' type='radio' name='answerOption' value='". $question['Answer'][1]['AnswerID'] . "'". ($question['Answer'][1]['AnswerID'] == $question['choice'] ? ' checked' : '') .">
                                <label class='form-check-label' for='a2'>". $question['Answer'][1]['AnswerText'] . "</label>
                            </div>
                            <div class='form-check'>
                                <input class='form-check-input' type='radio' name='answerOption' value='". $question['Answer'][2]['AnswerID'] . "'". ($question['Answer'][2]['AnswerID'] == $question['choice'] ? ' checked' : '') .">
                                <label class='form-check-label' for='a3'>". $question['Answer'][2]['AnswerText'] . "</label>
                            </div>
                            <div class='form-check'>
                                <input class='form-check-input' type='radio' name='answerOption' value='". $question['Answer'][3]['AnswerID'] . "'". ($question['Answer'][3]['AnswerID'] == $question['choice'] ? ' checked' : '') .">
                                <label class='form-check-label' for='a4'>". $question['Answer'][3]['AnswerText'] . "</label>
                            </div>";

        if ($question['answered'] == false) {
            $content .= "<button class='form-control mt-3 btn btn-primary' type='button' onclick='questionAnswered(this)'>Submit</button>";
        }
        $content .= "</form></div>";
        
        return $content;
    }
?>