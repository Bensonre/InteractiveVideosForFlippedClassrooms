<nav class="navbar navbar-expand-sm bg-dark navbar-dark">

    <a class="navbar-brand" href="#">Interactive Videos Demo</a>

        <ul class="navbar-nav">
            <?php
						$url = "http://localhost:8000";
            $content = array(
                "Instructor" => array(
                    "Upload Video" => ( "../demo/UploadVideo.php"),
                    "Create Questions" => ("../demo/CreateQuestions.php"),
                    "Create Package" => ("../demo/Package.php"),
                    "Add Questions to Package" => ("../demo/AddQuestions.php")
                ),
                "Student" => "../demo/Student.php?id=1",
                "Browse Packages" => "../demo/BrowsePackages.php"
            );


            foreach ($content as $page => $location) {
                if (is_array($location)) {
                    echo "<li class='nav-item dropdown'>";
                    echo "<a class='nav-link dropdown-toggle' href='#' id='navbardrop' data-toggle='dropdown'>Instructor</a>";
                    echo "<div class='dropdown-menu'>";
                    foreach ($location as $name => $link) {
                        echo "<a class='dropdown-item' href='$link'>$name</a>";
                    }
                    echo "</div>";
                    echo "</li>";
                }
                else {
                    echo "<li class='nav-item'><a class='nav-link' href='$location'>$page</a></li>";
                }
            }
            ?>
        </ul>
</nav>
