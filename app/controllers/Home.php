<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

$currentDirectory = __DIR__;
$newDirectory = dirname($currentDirectory, 2);
require $newDirectory . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->safeLoad();

class Home
{
    use Controller;

    public function index()
    {
        $data = ['title' => 'Moovie.'];
        $this->header($data);
        $this->view('home');
        $this->footer();
    }

}