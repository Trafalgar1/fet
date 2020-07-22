<?php
session_start();
//load builder
include_once "./resources/builder.php";

//Take URL
$temp=trim($_SERVER['REQUEST_URI'],'/');
$url= explode('/',$temp);

//Select the right site to build
if(!empty($url[0])){
    $url[0]= strtolower($url[0]);
    switch($url[0]){
        case 'archiv.php':
            build('archiv.php');
            break;
        case 'home.php':
            build('home.php');
            break;
        case 'feedback.php':
            build('feedback.php');
            break;
        case 'impressum.php':
            build('impressum.php');
            break;
        case 'API.php'	:
            require_once "./view/API.php";
            break;
        case 'apis.php':
            build('apis.php');
            break;
        default:
            build('404.php');
    }
}
else{
    build('home.php');
}
?>