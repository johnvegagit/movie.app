<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

$currentDirectory = __DIR__;
$newDirectory = dirname($currentDirectory, 2);
require $newDirectory . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->safeLoad();

class Logout
{

    use Controller;

    public function index()
    {
        session_start();
        session_unset();
        session_destroy();

        header('Location: ' . $_ENV['BASEURL'] . '?logout=success');
        die();
    }
}