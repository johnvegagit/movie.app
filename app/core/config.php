<?php
/**
 * URLPATH is a constant modify in app/core/config.php to oyur url.
 */
declare(strict_types=1);
defined('ROOTPATH') or exit . 'Access Denied!';

if ($_SERVER['SERVER_NAME'] === 'localhost') {
    define('URLPATH', 'http://localhost/public_html/movie.app/');
} else {
    # code...
}
