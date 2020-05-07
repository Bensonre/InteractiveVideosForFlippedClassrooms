var ivcCurrentPackageComponentTab;                      /* Used to keep track of the tab that the user is on. */
var ivcCreateTabInitialized = false;
var ivcUpdateTabInitialized = false;
var form_error = "Please fill out all input fields";

/* An enumeration for the existing tabs within the component. */
const ivcPackageComponentTabs = {
    CREATE: 'create',
    UPDATE: 'update',
    DELETE: 'delete',
    DUPLICATE: 'duplicate'
}

/**
 * When the window loads, fetch the packages and videos required for this component. Also, 
 * set the current tab of the component to 'CREATE'.
 */
window.onload = function() {
    getVideos();
    getPackages();
    setCurrentPackageComponentTab(ivcPackageComponentTabs.CREATE);
}

/**
 * Retrieves the current instructor's videos from the server.
 * 
 * Once the videos are received from the server, this function passes them into the function
 * 'fillVideos()' to insert them into the page. 
 */
function getVideos() {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            const videos = JSON.parse(this.responseText);

            videos.sort((a, b) => {
                if (a.title.toLowerCase() < b.title.toLowerCase()) { return -1; }
                if (a.title.toLowerCase() > b.title.toLowerCase()) { return 1; }
                return 0;
            });

            fillVideos(videos);
        }
    };
    const getURL = `${ivcPathToSrc}api/videos/read-all-with-instructor-id.php`;
    xhttp.open("GET", getURL, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

/**
 * Retrieves the current instructor's packages from the server.
 * 
 * Once the packages are received from the server, this function passes them into the function
 * 'fillPackages()' to insert them into the page. 
 */
function getPackages() {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var packages = JSON.parse(this.responseText);
            fillPackages(packages);
        }
    };
    const getURL = `${ivcPathToSrc}api/packages/read-all-with-instructor-id.php`;
    xhttp.open("GET", getURL, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send();
}

/**
 * This function inserts the given videos into the selection elements on the create and update
 * tabs of the component.
 * 
 * Afterwards, the create tab is initialized and the update tab is asked to be initialized as well. 
 * The update tab may not be initialized on this call because it requires that both videos and packages
 * have been inserted into the page.
 * 
 * @param videos An array of videos retrieved from the server.
 */
function fillVideos(videos) {
    let element = document.getElementById("create-package-select-video");
    let element2 = document.getElementById("update-package-select-video");
    element.innerHTML = "";
    element2.innerHTML  = "";

    for (let i = 0; i < videos.length; i++) {
        let option = document.createElement("option");
        option.value = videos[i].id;
        option.setAttribute('video-path', videos[i].filePath);
        option.setAttribute('isYouTube', videos[i].isYouTube);
        let text = document.createTextNode(videos[i].title);
        option.appendChild(text);
        let option2 = option.cloneNode(true);
        element.appendChild(option);
        element2.appendChild(option2);
    }

    // Create an unset video option on the update tab in case the package has no video.
    const unsetNode = document.createElement("option");
    unsetNode.value = -1;
    unsetNode.innerText = "<unset>";
    unsetNode.setAttribute("video-path", "");
    unsetNode.setAttribute("isyoutube", 0);
    element2.appendChild(unsetNode);

    if (!ivcCreateTabInitialized) {
        initializeCreateTab();
    }

    if (!ivcUpdateTabInitialized) {
        initializeUpdateTab();
    }
}

/**
 * This function inserts the given packages into the selection element on the update
 * tab of the component.
 * 
 * Afterwards, the update tab is asked to be initialized. 
 * The update tab may not be initialized on this call because it requires that both videos and packages
 * have been inserted into the page.
 * 
 * @param packages An array of packages retrieved from the server.
 */
function fillPackages(packages) {
    packages.sort( (a, b) => {
        if (a.title.toLowerCase() > b.title.toLowerCase()) { return 1;} else { return 0; }
    } );

    let element = document.getElementById("update-package-selection");
    let element2 = document.getElementById("delete-package-selection");
    let element3 = document.getElementById("duplicate-package-selection");
    element.innerHTML = "";
    element2.innerHTML = "";
    element3.innerHTML ="";
    for (let i = 0; i < packages.length; i++) {
        let option = document.createElement("option");
        option.setAttribute('video-id', packages[i].videoId);
        option.value = packages[i].id;
        let text = document.createTextNode(packages[i].title);
        option.appendChild(text);
        let option2 = option.cloneNode(true);
        let option3 = option.cloneNode(true);
        element.appendChild(option);
        element2.appendChild(option2);
        element3.appendChild(option3);
    }

    if (!ivcUpdateTabInitialized) {
        initializeUpdateTab();
    }
}

/**
 * Initializes the create tab.
 * 
 * An onchange listener is placed on the create tab's select element to handle when a new
 * video is selected by the user. The video player on this tab will then be loaded with the 
 * correct source and played. 
 */
function initializeCreateTab() {
    const selection = document.getElementById("create-package-select-video");
    selection.setAttribute("onchange", "createVideoSelectChanged()");

    // This prevents the player from starting if the user isn't on this tab on initial load.
    const player = videojs("Create-Package-video");
    player.on("loadedmetadata", () => {
        if (ivcCurrentPackageComponentTab != ivcPackageComponentTabs.CREATE) {
            player.pause();
        }
    });

    updateCreateTabVideo();
    playCreateTabVideo();
    ivcCreateTabInitialized = true;
}

/**
 * Initializes the update tab.
 * 
 * The following events only occur if both videos and packages have been inserted into the page already.
 * This function is called twice from functions 'fillVideos()' and 'fillPackages()'. An onchange listener 
 * is placed on the update tab's select elements to handle when a new package or new video is selected by the user. 
 * The video player on this tab will then be loaded with the correct source and played. 
 */
function initializeUpdateTab() {
    let packageSelection = document.getElementById("update-package-selection");
    let videoSelection = document.getElementById("update-package-select-video");
    if (packageSelection.length > 0 && videoSelection.length > 0) {
        packageSelection.setAttribute("onchange", "updatePackageSelectChanged()");
        videoSelection.setAttribute("onchange", "updateUpdateTabVideo()");

        // This prevents the player from starting if the user isn't on this tab on initial load.
        const player = videojs("Update-Package-video");
        player.on("loadedmetadata", () => {
            if (ivcCurrentPackageComponentTab != ivcPackageComponentTabs.UPDATE) {
                player.pause();
            }
        });

        updateUpdateTabPackage();
        ivcUpdateTabInitialized = true;
    }
}

/**
 * Creates a new package.
 * 
 * This function grabs the title and video id from the page and sends them to the server to create a new
 * package within the database.
 */
function createPackage() {
    const title = document.getElementById("create-package-title").value;
    const videoId = document.getElementById("create-package-select-video").value;

    //form validation
    if(!(title.length > 0) ||
        !(videoId.length > 0)) 
    {
            alert(form_error);
            return false;
    }

    let data = {
        "title": title, 
        "videoId": videoId
    };

    document.getElementById("ivc-create-package-status-message").innerText = "Processing...";

    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            document.getElementById("ivc-create-package-status-message").innerText = res.message;

            if (res.success) {
                document.getElementById("ivc-create-package-status-message").style.color = "green";
                document.getElementById("create-package-title").value = "";
            } else {
                document.getElementById("ivc-create-package-status-message").style.color = "red";
            }

            getPackages();
        }
    };
    const postURL = `${ivcPathToSrc}api/packages/create.php`;
    xhttp.open("POST", postURL, false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + JSON.stringify(data));
}

/**
 * Updates an existing package.
 * 
 * This function grabs the title, video id, and package id from the page and sends them to the server to update
 * an existing package within the database.
 */
function updatePackage() {
    const packageId = document.getElementById("update-package-selection").value;
    const title = document.getElementById("update-package-title").value;
    const videoId = document.getElementById("update-package-select-video").value;

    //form validation
    if(!(title.length > 0)     ||
        !(packageId.length > 0) ||
        !(videoId.length > 0))
    { 
            alert(form_error)
            return false;
    }

    let data = {
        "packageId": packageId,
        "title": title, 
        "videoId": videoId 
    };

    document.getElementById("ivc-update-package-status-message").innerText = "Processing...";

    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            document.getElementById("ivc-update-package-status-message").innerText = res.message;

            if (res.success) {
                document.getElementById("ivc-update-package-status-message").style.color = "green";
                let packageSelection = document.getElementById("update-package-selection");
                packageSelection.options[packageSelection.selectedIndex].setAttribute("video-id", videoId);
                packageSelection.options[packageSelection.selectedIndex].innerText = title;
            } else {
                document.getElementById("ivc-update-package-status-message").style.color = "red";
            }
        }
    };
    const postURL = `${ivcPathToSrc}api/packages/Update.php`;
    xhttp.open("POST", postURL, false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + JSON.stringify(data));
}

/**
 * Duplicates an existing package.
 * 
 * This function grabs the title and video id from the page and sends them to the server to duplicate
 * an existing package within the database.
 */
function duplicatePackage(){
    const oldId = document.getElementById('duplicate-package-selection').value;
    const newTitle = document.getElementById('duplicate-package-title').value;

    let data = {
        "oldPackageId": oldId,
        "newTitle": newTitle, 
    };

    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            document.getElementById("ivc-duplicate-package-status-message").innerText = res.message;
            if (res.success) {
                document.getElementById("ivc-duplicate-package-status-message").style.color = "green";
            } else {
                document.getElementById("ivc-duplicate-package-status-message").style.color = "red";
            }
        }
    };
    const postURL = `${ivcPathToSrc}api/packages/Duplicate.php`;
    xhttp.open("POST", postURL, false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + JSON.stringify(data));
}

/**
 * Deletes an existing package.
 * 
 * This function grabs the package id from the page and send it to the server to delete the package
 * within the database.
 */
function deletePackage() {

    const packageId = document.getElementById("delete-package-selection").value;

    //form validation
    if(!(packageId.length > 0))
    {
            alert(form_error);
            return false;
    }

    let data = {
        "packageId": packageId
    };

    document.getElementById("ivc-delete-package-status-message").innerText = "Processing...";

    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var res = JSON.parse(this.responseText);
            document.getElementById("ivc-delete-package-status-message").innerText = res.message;

            if (res.success) {
                document.getElementById("ivc-delete-package-status-message").style.color = "green";
            } else {
                document.getElementById("ivc-delete-package-status-message").style.color = "red";
            }

            let updateOption = document.querySelector("#update-package-selection option[value='" + packageId + "']");
            let deleteOption = document.querySelector("#delete-package-selection option[value='" + packageId + "']");
            updateOption.remove();
            deleteOption.remove();
        }
    };
    const postURL = `${ivcPathToSrc}api/packages/Delete.php`;
    xhttp.open("POST", postURL, false);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("data=" + JSON.stringify(data));
}

/**
 * Is triggered when the video select element on the create tab is changed.
 */
function createVideoSelectChanged() {
    updateCreateTabVideo();
    playCreateTabVideo();
}

/**
 * Is triggered when the package select element on the update tab is changed.
 */
function updatePackageSelectChanged() {
    updateUpdateTabPackage();
    playUpdateTabVideo();
}

/**
 * Updates the source of the video player on the create tab with the currently selected video.
 */
function updateCreateTabVideo(){
    const selection = document.getElementById("create-package-select-video");
    const player = videojs("Create-Package-video");
    const path = selection.options[selection.selectedIndex].getAttribute("video-path");
    const isYouTube = selection.options[selection.selectedIndex].getAttribute("isYouTube");

    if (Number(isYouTube)) {
        player.src({src: `${path}`, type: 'video/youtube'});
    } else {
        player.src({src: `${ivcPathToSrc}/${path}`, type: 'video/mp4'});
    }
}

/**
 * Updates the title and video fields on the update tab with the attributes of the currently selected package.
 */
function updateUpdateTabPackage(){
    let packageTitle = document.getElementById("update-package-title");
    let packageSelection = document.getElementById("update-package-selection");
    let videoSelection = document.getElementById("update-package-select-video");
    packageTitle.value = packageSelection.options[packageSelection.selectedIndex].text;

    let search = Array.from(videoSelection.options).find(x=> x.value == packageSelection.options[packageSelection.selectedIndex].getAttribute('video-id'));

    // If the video doesn't exist, use the unset video option.
    let index = -1;
    if (search != null) {
        videoSelection.selectedIndex = search.index;
    } else {
        videoSelection.selectedIndex = Array.from(videoSelection.options).find(x => x.value == -1).index; // The unset video option.
    }

    updateUpdateTabVideo();
}

/**
 * Updates the source of the video player on the update tab with the currently selected video.
 */
function updateUpdateTabVideo(){
    const selection = document.getElementById("update-package-select-video");
    const player = videojs("Update-Package-video");
    const path = selection.options[selection.selectedIndex].getAttribute("video-path");
    const isYouTube = selection.options[selection.selectedIndex].getAttribute("isYouTube");

    if (Number(isYouTube)) {
        player.src({src: `${path}`, type: 'video/youtube'});
    } else {
        player.src({src: `${ivcPathToSrc}/${path}`, type: 'video/mp4'});
    }
}

/**
 * Sets the current tab and decides whether to play the video player on the create tab or update tab.
 * 
 * @param tab The tab to set as the current tab.
 */
function setCurrentPackageComponentTab(tab) {
    ivcCurrentPackageComponentTab = tab;

    if (ivcCurrentPackageComponentTab == ivcPackageComponentTabs.CREATE) {
        pauseUpdateTabVideo();
        playCreateTabVideo();
    } else if (ivcCurrentPackageComponentTab == ivcPackageComponentTabs.UPDATE) {
        pauseCreateTabVideo();
        playUpdateTabVideo();
    } else {
        pauseCreateTabVideo();
        pauseUpdateTabVideo();
    }
}

/**
 * Plays the video player on the create tab.
 */
function playCreateTabVideo() {
    const player = videojs("Create-Package-video");

    if (player.paused()) {
        player.play();
    }
}

/**
 * Pauses the video player on the create tab.
 */
function pauseCreateTabVideo() {
    const player = videojs("Create-Package-video");

    if (!player.paused()) {
        player.pause();
    }
}

/**
 * Plays the video player on the update tab.
 */
function playUpdateTabVideo() {
    const player = videojs("Update-Package-video");

    if (player.paused()) {
        player.play();
    }
}

/**
 * Pauses the video player on the update tab.
 */
function pauseUpdateTabVideo() {
    const player = videojs("Update-Package-video");

    if (!player.paused()) {
        player.pause();
    }
}