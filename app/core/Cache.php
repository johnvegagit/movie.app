<?php
declare(strict_types=1);
defined('ROOTPATH') or exit . 'Access Denied!';

/**
 * This script wil remove every expired cache automatic.
 * Using cron jobs.
 * Cron jobs will be execute every 24 hours.
 * Cron jobs: 0 0 * * * /opt/lampp/bin/php /opt/lampp/htdocs/public_html/framework-v1/app/core/Cache.php
 */

// Modify to root directory.
$currentDirectory = __DIR__;
$rootDirectory = dirname($currentDirectory, 2);

$cache_dir = "$rootDirectory/app/cache/";
$cache_expiration = 24 * 60 * 60; // 24 hours

function clean_expired_cache($cache_dir, $cache_expiration, $rootDirectory)
{
    if (is_dir($cache_dir)) {
        foreach (glob("$cache_dir*.cache") as $cache_file) {
            if ((time() - filemtime($cache_file)) >= $cache_expiration) {
                unlink($cache_file);
                file_put_contents("$rootDirectory/app/log/cache.log", "Success:: cache file deleted: $cache_file\n", FILE_APPEND);
            } else {
                file_put_contents("$rootDirectory/app/log/cache.log", "Error:: cache file not deleted: $cache_file\n", FILE_APPEND);
            }
        }
    } else {
        file_put_contents("$rootDirectory/app/log/cache.log", "Error:: cache directory not find\n", FILE_APPEND);
    }
}

clean_expired_cache($cache_dir, $cache_expiration, $rootDirectory);
file_put_contents("$rootDirectory/app/log/cache.log", "Success:: cron job executed at: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
