<div class="section-title">
        Upload Video
    </div>
    <form method="Post">
        <div class="label">Upload Video</div>
        <input type="file" name="file" id="file" class="inputfile PushLeft1">
        <label class="fileLable" for="file">
          <div class="input-mimic">
            <span></span>
            <span class="dropdown-triangle"\>
          </div>
        </label>
        <button class="submit" type="submit">Upload</button>
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
</div>
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