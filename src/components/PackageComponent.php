<div class="section-title">
        Create or Select a Package
    </div>
    <form method="Post">
        <div class="label">Select a video</div>
        <select class="PushLeft1"></select>
        <div class="label">
            Name the Package
        </div>
        <input placeholder="Video Name" Type="text" class="PushLeft1"/>
            <button class="submit" type="Submit">Submit</button>
        <div class="label">
            Or
        </div>
        <br/>
        <br/>
        <div class="label">Select an exsisting package</div>
        <select class="PushLeft1"></select><div class="label">Select New video</div>
        <select class="PushLeft1"></select>

        <button class="submit" type="Submit">Submit</button>
    </form>
    <div class="label">
        Selected Video
    </div>
		
    <video-js
    id="CreatePackage-video"
    controls 
    data-setup="{}"
    >
      <source src="http://clips.vorwaerts-gmbh.de/VfE_html5.mp4" type="video/mp4">
    </video-js>

</div>
