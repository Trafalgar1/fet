<?php
include_once "./resources/datenbank.php";

if(isset($_GET['icao'])){
$icao=$_GET['icao'];
}
    $model=(getModel($icao)->fetch_assoc());

    $manufacturer=(getManufacturerename($icao)->fetch_assoc());
if (isset($model)&&isset($manufacturer)) {
    echo $model["model"], ",", $manufacturer["manufacturername"];
}
?>
