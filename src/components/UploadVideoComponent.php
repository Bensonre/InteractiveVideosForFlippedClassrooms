<div class="section-title">
        Upload Video
    </div>
    <form>
        <div class="label">Upload Video</div>
        <input type="file" name="fileToUpload" id="file" class="inputfile PushLeft1">
        <label class="fileLable" for="file">
          <div class="input-mimic">
            <span></span>
            <span class="dropdown-triangle"\>
          </div>
        </label>
        <button class="submit" type="button" onclick="sendData()">Upload</button>
        <div class="label">
            Or
        </div>
        <br/>
        <br/>
        <div class="label">
            Provide and Unlisted Youtube Video Link
        </div>
        <input class="PushLeft1" type="text"
            placeholder="Input a link to an unlisted youtube video here" />
        <button class="submit" type="Submit">Submit</button>
    </form>
    <div id="message"></div>
</div>


<script>
    function sendData() {
        var formData = new FormData();
        var fileInput = document.getElementById("file");

        if (fileInput.files && fileInput.files.length == 1) {
            var file = fileInput.files[0];
            formData.set("fileToUpload", file, file.name);
        }

        document.getElementById("message").innerText = "Processing...";

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var res = JSON.parse(this.responseText);
                document.getElementById("message").innerText = res.message;

                if (res.success) {
                    document.getElementById("message").style.color = "green";
                } else {
                    document.getElementById("message").style.color = "red";
                }
            }
        };
        xhttp.open("POST", "../api/videos/create.php", false);
        xhttp.send(formData);
    }
</script>

<script>
var inputs = document.querySelectorAll( '.inputfile' );
Array.prototype.forEach.call( inputs, function( input )
{
	var label	 = input.nextElementSibling,
		labelVal = label.innerHTML;

	input.addEventListener( 'change', function( e )
	{
		var fileName = '';
        
        fileName = e.target.value.split( '\\' ).pop();
        
        if( fileName )
			label.querySelector( 'span' ).innerHTML = fileName;
		else
			label.innerHTML = labelVal;
	});
});
</script>
