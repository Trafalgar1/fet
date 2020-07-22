<?php

    function connection() {
        $db = new Mysqli(
            "localhost", 
            "root", 
            "", 
            "fet"
        );
        return $db;
    }
    //Datenbank abfrage für Herstellername
    function getManufacturerename($icao){
        $sql = "SELECT manufacturername FROM aircraftdatabase WHERE icao24='$icao'";
        $db = connection();
        $mName = $db->query($sql);
        $db->close();
        return $mName;
    }
    //Datenbank abfrage für Model
    function getModel($icao){
        $sql = "SELECT model FROM aircraftdatabase WHERE icao24='$icao'";
        $db = connection();
        $model = $db->query($sql);
        $db->close();
        return $model;
    }
    function getOperator($icao){
        $sql = "SELECT operator FROM aircraftdatabase WHERE icao24='$icao'";
        $db = connection();
        $operator = $db->query($sql);
        $db->close();
        return $operator;
    }
    //Überprüft ob Fluggesellschaft in Datenbank und gibt CO2-Wert der Fluggesellschaft zurück
    function getCO2($fluggesellschaft){
        $sql= "SELECT CO2Fluggesellschaft FROM operatordatabase WHERE NameFluggesellschaft LIKE '$fluggesellschaft'";
        $db = connection();
        $co2 = $db->query($sql);
        $db->close();
        return $co2;

    }
    

?>