var ivcPathToSrc = "";  /* Stores the path to this project's source code. */

/**
 * Initializes the path to the project's 'src' folder so that the JavaScript knows how to navigate 
 * to the resources it needs.
 * 
 * @param {*} path The directory path to the but not including the src folder.
 */
function ivcPathToSrcInitializer(path) {
    ivcPathToSrc = `${path}src/`;
}