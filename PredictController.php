<?php
    $rainfall = $_GET['rainfall'];
    $humid3 = $_GET['humid3'];
    $humid9 = $_GET['humid9'];
    $predictToday = exec("python3 predictToday.py $rainfall $humid3 $humid9");

    header("Location: predict.php?resultToday=".$predictToday[0]);
?>