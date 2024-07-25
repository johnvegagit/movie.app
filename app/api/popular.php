<?php
declare(strict_types=1);

// Load dotNet.
$currentDirectory = __DIR__;
$newDirectory = dirname($currentDirectory, 2);
require "$newDirectory/vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->safeLoad();

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: http://localhost/public_html/movie.app');

$api_key = $_ENV['TMDB_API_KEY'];
$url = "https://api.themoviedb.org/3/movie/popular?api_key=$api_key";

$response = file_get_contents($url);

if ($response === FALSE) {
    http_response_code(500);
    echo json_encode(['error' => 'Error occurred while fetching data']);
    exit;
}

echo $response;
