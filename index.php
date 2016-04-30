<?php
define('APP_BASEURL', dirname(__FILE__));
// Merjiezo is so cool
require (__DIR__ .'/lib/autoload.php');

$website = Router::getinstance();
$HTML    = $website->getControllerFactory();
echo $HTML?$HTML:'';