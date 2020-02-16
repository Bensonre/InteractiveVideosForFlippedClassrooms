<div class="container">
    <form class="border bordered p-4">
        <h2 class="text-center">Create Questions</h2>
        <div class="form-group">
            <label>Question</label>
            <textarea id="ivc-question" class="form-control" rows="3" placeholder="Write your question here..." name="question"></textarea>
        </div>

        <div class="form-group">
            <label>Category</label>
            <input id="ivc-category" class="form-control" type="text" placeholder="Enter a category for filtering..." name="category" />
        </div>

        <div class="form-group">
            <label>Answers</label>
            <input id="ivc-a1" class="form-control" type="text" name="a1">
            <input id="ivc-a2"class="form-control" type="text" name="a2">
            <input id="ivc-a3"class="form-control" type="text" name="a3">
            <input id="ivc-a4"class="form-control" type="text" name="a4">
        </div>

        <div class="form-group">
            <label>Which answer is the correct one?</label>
                <select id="ivc-select-answer" class="form-control" name="correct">
                    <option value="1">Answer 1</option>
                    <option value="2">Answer 2</option>
                    <option value="3">Answer 3</option>
                    <option value="4">Answer 4</option>
                </select>

            <button class="form-control mt-3 btn btn-primary" type="button" onclick="createQuestion()">Create</button>
        </div>
        <div id="ivc-create-question-status-message" class="text-center"></div>
    </form>
</div>