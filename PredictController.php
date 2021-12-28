<?php
    session_start();
    $rainfall = $_GET['rainfall'];
    $humid3 = $_GET['humid3'];
    $humid9 = $_GET['humid9'];
    $predictToday = exec("python3 predictToday.py $rainfall $humid3 $humid9");
    $_SESSION['Today'] = $predictToday;

    header('Location: predict.php');
?>