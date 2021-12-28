<?php
$location = $_REQUEST["location"];

$arrRes = exec("python getDateFromCSV.py $location");
if($arrRes != null){
    print_r($arrRes);
}
?>