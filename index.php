<?php
//Merjiezo is so cool
include ('lib/Router.php');
$website = Router::getinstance();
$HTML    = $website->getControllerFactory();
echo $HTML;