<?php
session_start();

$date = $_REQUEST["date"];
$rows = $_SESSION['rows'];

$selectedRow = null;
foreach ($rows as $value) {
    if($value[0] == $date){
        $selectedRow = $value;
    }
}

if($selectedRow != null){
    $selectedRow = json_encode($selectedRow);
    print_r($selectedRow);
}
?>