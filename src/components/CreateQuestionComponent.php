<div class="section-title">
        Create Question
    </div>
    <form method="Post">
        <div class="label">
            Question
        </div>
        <textarea Class="PushLeft1" placeholder="Write your question here..."></textarea>
        <div class="label">
            Catagory
        </div>
        <input class="PushLeft1" type="text"
            placeholder="Input a catagory you can filter by later to help find this question" />
        <div class="label">Answers</div>
        <!-- change this to loop in php-->
        <div class="inputgroup">
            <Span class="label"> 1 </Span>
            <input type="text">
        </div>
        <div class="inputgroup">
            <Span class="label"> 2 </Span>
            <input type="text">
        </div>
        <div class="inputgroup">
            <Span class="label"> 3 </Span>
            <input type="text">
        </div>
        <div class="inputgroup">
            <Span class="label"> 4 </Span>
            <input type="text">
        </div>
        <button class="submit" id="question-submit" type="button">Submit</button>
    </form>
    <div id="grey-cover">
        <div id="Another-Question-Modal" class="modal">
            <span class="close">&times;</span>
            <br/>
            <div class="label">Add another question?</div>
            <button class="button-positive">Yes</button>
            <button class="button-negative">No</button>
        </div>
    </div>
    <script src="Modal.js"></script>