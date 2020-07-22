<?php
include_once "./resources/datenbank.php";
if(isset($_GET['icao'])){
    $icao=$_GET['icao'];
}
$model=(getModel($icao)->fetch_assoc());
$manufacturer=(getManufacturerename($icao)->fetch_assoc());
$operator=(getOperator($icao)->fetch_assoc());
$operator= $operator["operator"];
$operatorCO2=(getCO2($operator)->fetch_assoc());
if (isset($model)&&isset($manufacturer)&&isset($operatorCO2)) {
    echo $model["model"], ",", $manufacturer["manufacturername"],",",$operatorCO2["CO2Fluggesellschaft"];
}
?>
