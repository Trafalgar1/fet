<?php
if(isset($_GET['timeStart'])){
    $timeStart=$_GET['timeStart'];
}
if(isset($_GET['timeEnd'])){
    $timeEnd=$_GET['timeEnd'];
}
echo  file_get_contents("https://trafalgar1:Trafalgar3@opensky-network.org/api/flights/all?begin=$timeStart&end=$timeEnd");?>
