<?php
include_once 'dbConnector.php';
$results_per_page = 10;
if (isset($_GET['pageno'])) {
    $pageno = (int)$_GET['pageno'];
    $page_first_result = ($pageno - 1) * $results_per_page;
} else {
    $pageno = 1;
    $page_first_result = 0;
}

$sqlTutor = "SELECT * FROM tbl_tutors";



$stmt = $conn->prepare($sqlTutor);
$stmt->execute();
$number_of_result = $stmt->rowCount();
$number_of_page = ceil($number_of_result / $results_per_page);
$sqlTutor = $sqlTutor . " LIMIT $page_first_result , $results_per_page";
$stmt = $conn->prepare($sqlTutor);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();


function truncate($string, $length, $dots = "...") {
    return (strlen($string) > $length) ? substr($string, 0, $length - strlen($dots)) . $dots : $string;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="css/multi.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">


</head>

<body>
    <div class="w3-header w3-black w3-display-container" style="height: 110px;">
    <div id="mySidebar" class="w3-sidebar w3-bar-block" style="display: none;">
            <button onclick="w3_close()" class="w3-bar-item w3-button w3-large">&times;</button>
            <a href="index.php" class="w3-bar-item w3-button">Dashboard</a>
            <a href="course.php" class="w3-bar-item w3-button">Courses</a>
            <a href="tutor.php" class="w3-bar-item w3-button">Tutors</a>
            <a href="#" class="w3-bar-item w3-button">Subscriptions</a>
            <a href="#" class="w3-bar-item w3-button">Profile</a>
            <a href="login.php" class="w3-bar-item w3-button">Logout</a>
        </div>
        <div id="innerHeader">

            <div id="logoTutor">
            <button class="w3-button w3-xlarge" style= "margin-top:28px;" onclick="w3_open()">&#9776;</button>   
                <h1><b>My Tutor</b></h1>
            </div>

            <div id="navigationMenu" class="w3-hide-small w3-hide-medium">
                <ul>
                    <a href="course.php">
                        <li>Courses</li>
                    </a>
                    <a href="tutor.php">
                        <li>Tutors</li>
                    </a>
                    <a>
                        <li>Subcription</li>
                    </a>
                    <a>
                        <li style="padding-right: 60px;">Profile</li>
                    </a>
                </ul>
            </div>

        </div>

    </div>

    <div class="w3-display-container tutorBImg" >
        <p style="font-size: 50px; margin:0px;padding:20px; text-align:center">Tutors</p>

    </div>

    <div class="w3-card w3-container w3-padding w3-margin w3-round" id="searchBar" style="text-align:center">

        <input type="text" placeholder="Search tutors here">



        <button>
            <i class="fa fa-search"></i>
            Search
        </button>

    </div>

    <div class="grid-container">

        <?php

        $i = 0;
        foreach ($rows as $tutors) {
            $i += 1;
            if ($i == 11) {
                break;
            }
            $tutorId = $tutors['tutor_id'];
            $tutorName = truncate($tutors['tutor_name'],50);
            echo "<div class='grid-item'><img src='assets/tutors/$tutorId.jpg'>
                <p><b>$tutorName</b></p></div>";
        }

        ?>

    </div>
    <br>
    <?php
    $num = 1;
    if ($pageno == 1) {
        $num = 1;
    } else if ($pageno == 2) {
        $num = ($num) + 10;
    } else {
        $num = $pageno * 10 - 9;
    }
    echo "<div class='w3-container w3-row'>";
    echo "<center>";
    for ($page = 1; $page <= $number_of_page; $page++) {
        echo '<a href = "tutor.php?pageno=' . $page . '" style=
            "text-decoration: none">&nbsp&nbsp' . $page . ' </a>';
    }
    echo " ( " . $pageno . " )";
    echo "</center>";
    echo "</div>";
    ?>
    <br>


    <footer class="w3-container w3-center w3-black">
        <p>MyTutor <br>Designed by Woon</p>

    </footer>

 
    <script src = "tutor.js"></script>
</body>

</html>