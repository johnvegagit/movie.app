<?php
/** Validate php version */
$minPHPVersion = "8.2.12";
if (phpversion() < $minPHPVersion) {
    die("<pre>Your PHP Version must be {$minPHPVersion} or higher to run this app. Your current vertion is " . phpversion() . "</pre>");
}

/** Denied access app directories */
define('ROOTPATH', __DIR__ . DIRECTORY_SEPARATOR);

require 'vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

$DS = DIRECTORY_SEPARATOR;
include __DIR__ . $DS . 'app' . $DS . 'core' . $DS . 'init.php';

$app = new App;
$app->startApp();