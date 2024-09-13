<?php
session_start();
require_once "include.php";

if (!isset($_SERVER['PATH_INFO'])) {
    
    $_SERVER['PATH_INFO'] = "Login";
}

$_SERVER['PATH_INFO'] = trim($_SERVER["PATH_INFO"], "/");
$url = explode("/", $_SERVER["PATH_INFO"]);

$action = $url[0];

$root = array(
    "Login", "LoginAction", "Signin", "SigninAction", "Accueil", "Compte", "UpdateUserCompte", "Membres", "Projets","ProjetsAction",
    "TachesAction", "FaireTache", "UpdateProgression", "Comments"
);

if (!in_array($action, $root)) {
    
    $content = "URL NOT FOUND ";
    $title = "Page Error ";
}
$title = "Page ".ucwords($action);
$function = "display".ucwords($action);
$content = $function();

require_once VIEW.SP."view.php";

//print_r($url);