<header>
    <div class=" title PushLeft5">Interactive Video for Flipped Classroom</div>
    <nav class="NavBar">
        <ul>
            <?php
						$url = "http://localhost:8000";
            $content = array(
                "Instructor" => array(
                    "Upload Video" => ( "../demo/UploadVideo.php"),
                    "Create Questions" => ("../demo/CreateQuestions.php"),
                    "Create Package" => ("../demo/Package.php"),
                    "Add Questions to Package" => ("../demo/AddQuestions.php"),
                    "Update Question" => ("../demo/UpdateQuestion.php")
                ),
                "Student" => "../demo/Student.php"
            );

            foreach ($content as $page => $location) {
                if (is_array($location)) {
                    if ($page == $currentpage) {
                        echo "<li class='navItem PushLeft5 Selected'><a id='instr' href='#'>$page</a>
                                <ul id='drop-down'>";
                    } else {
                        echo "<li class='navItem PushLeft5'><a id='instr' href='#'>$page</a>
                        <ul id='drop-down'>";
                    }
                    foreach ($location as $name => $link) {
                        echo "<li><a href='$link'>$name</a></li>";
                    }
                    echo "</ul>";
                }
                else if ($page == $currentpage) {
                    echo "<li class='navItem PushLeft5 Selected'><a href='$location'>$page</a></li>";
                } else {
                    echo "<li class='navItem PushLeft5'><a href='$location'>$page</a></li>";
                }
            }
            ?>
        </ul>
    </nav>
</header>
<script src="/js/Site.js"></script>
