<?php
define("SP", DIRECTORY_SEPARATOR);
define("MODEL", dirname(__DIR__).SP."model");
define("VIEW", dirname(__DIR__).SP."view");
define("CONFIG", dirname(__DIR__).SP."config");
define("BASE_URL", dirname(dirname($_SERVER['SCRIPT_NAME'])));
require_once CONFIG.SP."config.php";
require_once MODEL.SP."model.class.php";
require_once "functions.php";

$model = new projectLayer();


//$projet = $model->updateProgression(9, "50%");

//$tache = $model->createTache(1,"Front end","HTML, CSS", "LIGHT", "2024-12-10", "2024-12-17");

//print_r($projet); exit();