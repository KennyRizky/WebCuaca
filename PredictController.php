<?php
    $rainfall = $_GET['rainfall'];
    $humid3 = $_GET['humid3'];
    $humid9 = $_GET['humid9'];
    
    $predictToday = exec("python3 predictToday.py $rainfall $humid3 $humid9");

    $sunshine = $_GET['sunshine'];
    $cloud3 = $_GET['cloud3'];

    $predictTomorrow = exec("python3 predictTomorrow.py $sunshine $humid3 $cloud3");

    header("Location: predict.php?resultTomorrow=".$predictTomorrow[1]."&resultToday=".$predictToday[1]);
?>