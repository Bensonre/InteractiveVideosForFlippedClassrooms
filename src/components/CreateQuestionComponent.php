<div class="section-title">
        Create Question
    </div>
    <form method="Post" action="../api/questions/create.php" name="f1">
        <div class="label">
            Question
        </div>
        <textarea Class="PushLeft1" placeholder="Write your question here..." name="question"></textarea>
        <div class="label">
            Catagory
        </div>
        <input class="PushLeft1" type="text"
            placeholder="Input a category you can filter by later to help find this question" name="category" />
        <div class="label">Answers</div>
        <!-- change this to loop in php-->
        <div class="inputgroup">
            <Span class="label"> 1 </Span>
            <input type="text" name="a1">
        </div>
        <div class="inputgroup">
            <Span class="label"> 2 </Span>
            <input type="text" name="a2">
        </div>
        <div class="inputgroup">
            <Span class="label"> 3 </Span>
            <input type="text" name="a3">
        </div>
        <div class="inputgroup">
            <Span class="label"> 4 </Span>
            <input type="text" name="a4">
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

        <button class="submit" id="question-submit" type="submit" name="submit">Submit</button>
    </form>
		<!--
    <div id="grey-cover">
        <div id="Another-Question-Modal" class="modal">
            <span class="close">&times;</span>
            <br/>
            <div class="label">Add another question?</div>
            <button class="button-positive">Yes</button>
            <button class="button-negative">No</button>
        </div>
    </div>
    <script src="../js/Modal.js"></script>
		-->
