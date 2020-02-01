<div class="section-title">
        Update Question
    </div>
    <form method="Post" action="../api/questions/update.php" name="f1" onSubmit="return validateForm()">
        <div class="label">Select Question</div>
        <select class="PushLeft1" name="wutQ">
        <?php
          include_once "../includes/connectvars.php";
          include_once "../controllers/QuestionController.php";
          $rd = new QuestionController($mysqli);
          $result = $rd->read();
          $result->bind_result($id ,$text ,$cat, $date);

          echo "<option value='#'> ---- </option>"; 
          while($result->fetch()) {
            echo "<option value='" . $id . "'>" . $text . "</option>";
          }
        ?>
        </select>
        <div class="label">
            Question
        </div>
        <textarea Class="PushLeft1" placeholder="Write your question here..." name="question"></textarea>
        <div class="label">
            Catagory
        </div>
        <input class="PushLeft1" type="text"
            placeholder="Input a catagory you can filter by later to help find this question" name="category"/>
        <div class="label">Answers</div>
        <!-- change this to loop in php-->
        <div class="inputgroup">
            <Span class="label"> 1 </Span>
            <input type="text" name="c1">
        </div>
        <div class="inputgroup">
            <Span class="label"> 2 </Span>
            <input type="text" name="c2">
        </div>
        <div class="inputgroup">
            <Span class="label"> 3 </Span>
            <input type="text" name="c3">
        </div>
        <div class="inputgroup">
            <Span class="label"> 4 </Span>
            <input type="text" name="c4">
        </div>
         <div class="label"> 
					 Which answer is the correct one?
				 </div>
				<select class="PushLeft1" name="correct">
				  <option value="1">Answer 1</option>
				  <option value="2">Answer 2</option>
				  <option value="3">Answer 3</option>
				  <option value="4">Answer 4</option>
				</select>

        <button class="submit" id="question-submit" type="Submit">Submit</button>
    </form>
</div>
