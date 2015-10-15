<!DOCTYPE html>
<html>
<head>
    <title>Course list</title>
    <meta charset="utf-8" />
    <link href="courses.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div id="header">
    <h1>Courses at CSE</h1>
<!-- Ex. 1: File of Courses -->
    <?php
        $filename = "courses.tsv";
        $lines = file($filename);

        $num_courses = sizeof($lines);
        $size = filesize($filename);

        $numberOfCourses = 3;

        if(isset($_GET["number_of_courses"])){
            $numberOfCourses = $_GET["number_of_courses"];
        }
        if(empty($numberOfCourses)) {
            $numberOfCourses = 3;
        }

        $startCharacter = 'C';
        if(isset($_GET["character"])){
            $startCharacter = $_GET["character"];
        }
        if(empty($startCharacter)) {
            $startCharacter = 'C';
        }

        $orderby = 0;
        if(isset($_GET["orderby"])){
            $orderby = $_GET["orderby"];
        }
        if(empty($orderby)) {
            $orderby = 0;
        }

        ?>
    <p>
        Course list has <?= $num_courses ?> total courses
        and
        size of <?= $size ?> bytes.
    </p>
</div>
<div class="article">
    <div class="section">
        <h2>Today's Courses</h2>
<!-- Ex. 2: Today’s Courses & Ex 6: Query Parameters -->
        <?php
            function getCoursesByNumber($listOfCourses, $numberOfCourses){
                $resultArray = array();
//                implement here.
                shuffle($listOfCourses);
                foreach ($listOfCourses as $courseItem) {
                    $item = explode("\t", $courseItem);
                    $resultArray[] = $item[0] . " - " . $item[1];
                }
                $resultArray = array_slice($resultArray, 0, $numberOfCourses);
                return $resultArray;
            }
        ?>
        <ol>
            <?php
                $todaysCourses = getCoursesByNumber($lines, $numberOfCourses);
                foreach ($todaysCourses as $listItem) { ?>
                    <li><?= $listItem ?></li>
                <?php } ?>

            <!-- <li>CRYPTOGRAPHY - CSE3029</li> -->
            <!-- <li>SOFTWARE CONVERGENCE STRATEGY - CSE3031</li> -->
            <!-- <li>BIG DATA PROCESSING - CSE4036</li> -->
        </ol>
    </div>
    <div class="section">
        <h2>Searching Courses</h2>
<!-- Ex. 3: Searching Courses & Ex 6: Query Parameters -->
        <?php
            function getCoursesByCharacter($listOfCourses, $startCharacter){
                $resultArray = array();
//                implement here.
                foreach ($listOfCourses as $courseItem) {
                    if(strpos($courseItem, $startCharacter) === 0) {
                        $item = explode("\t", $courseItem);
                        $resultArray[] = $item[0] . " - " . $item[1];
                    }
                }
                return $resultArray;
            }
        ?>
        <p>
            Courses that started by <strong>'<?= $startCharacter ?>'</strong> are followings :
        </p>
        <ol>
            <?php
                $searchedCourses = getCoursesByCharacter($lines, $startCharacter);
                foreach ($searchedCourses as $searchedItem) { ?>
                    <li><?= $searchedItem ?></li>
                <?php } ?>

            <!-- <li>COMPILER CONSTRUCTION - CSE3009</li> -->
            <!-- <li>COMPUTER NETWORKS - CSE3027</li> -->
            <!-- <li>CRYPTOGRAPHY - CSE3029</li> -->
        </ol>
    </div>
    <div class="section">
        <h2>List of Courses</h2>
<!-- Ex. 4: List of Courses & Ex 6: Query Parameters -->
        <?php
            function getCoursesByOrder($listOfCourses, $orderby){
                $resultArray = $listOfCourses;
//                implement here.
                if ($orderby == 0) {
                    sort($resultArray);
                }
                elseif ($orderby == 1) {
                    rsort($resultArray);
                }
                return $resultArray;
            }
        ?>
        <p>
            All of courses ordered by <strong>alphabetical order</strong> are followings :
        </p>
        <ol>
            <?php
                $orderedCourses = getCoursesByOrder($lines, $orderby);
                foreach ($orderedCourses as $orderedItem) {
                    $item = explode("\t", $orderedItem);
                    if (strlen($item[0]) > 20) { ?> 
                        <li class="long"><?= $item[0] . " - " . $item[1] ?></li>
                    <?php }
                    else { ?>
                        <li><?= $item[0] . " - " . $item[1] ?></li>
                    <?php }
                } ?>

            <!-- <li class="long">ARTIFICIAL INTELLIGENCE - CSE4007</li>
            <li>BIG DATA PROCESSING - CSE4036</li>
            <li class="long">COMPILER CONSTRUCTION - CSE3009</li>
            <li>COMPUTER NETWORKS - CSE3027</li>
            <li>CRYPTOGRAPHY - CSE3029</li>
            <li class="long">EMBEDDED OPERATING SYSTEMS - CSE4035</li>
            <li>MOBILE COMPUTING - CSE4045</li>
            <li class="long">SOFTWARE CONVERGENCE STRATEGY - CSE3031</li>
            <li class="long">WEB APPLICATION DEVELOPMENT - CSE3026</li> -->
        </ol>
    </div>
    <div class="section">
        <h2>Adding Courses</h2>
<!-- Ex. 5: Adding Courses & Ex 6: Query Parameters -->
    <?php
        $newCourse;
        $codeOfCourse;
        if(isset($_GET["new_course"]) && isset($_GET["code_of_course"])) {
            $newCourse = $_GET["new_course"];
            $codeOfCourse = $_GET["code_of_course"];

            $data = "\n" . $newCourse . "\t" . $codeOfCourse;

            if (file_put_contents($filename, $data, FILE_APPEND)) { ?>
                <p>Adding a course is success!</p>
            <?php } 
        }
        else { ?>
            <p>Input course or meaning of code of the course doesn't exist.</p>
        <?php } ?>

    </div>
</div>
<div id="footer">
    <a href="http://validator.w3.org/check/referer">
        <img src="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/images/w3c-html.png" alt="Valid HTML5" />
    </a>
    <a href="http://jigsaw.w3.org/css-validator/check/referer">
        <img src="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/images/w3c-css.png" alt="Valid CSS" />
    </a>
</div>
</body>
</html>