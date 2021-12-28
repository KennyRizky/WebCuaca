<?php
    session_start();
    echo $_GET['location'];
    echo '<br>';
    echo $_GET['dateFrom'];
    echo "<br>";
    echo $_GET['dateTo'];

    //save location
    $_SESSION['location'] = $_GET['location'];

    //save dates
    $_SESSION['dateFrom'] = $_GET['dateFrom'];
    $_SESSION['dateTo'] = $_GET['dateTo'];

    //save weather values
    $csvRow = exec("python getWeatherValues.py $_GET[location] $_GET[dateFrom] $_GET[dateTo]");
    $arr = json_decode($csvRow);
    $_SESSION["rows"] = $arr;

    header('Location: SearchPage.php');
?>
