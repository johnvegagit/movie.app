<?php
/**
 * This is the main model to do CRUD.
 * You can select data from database or from cache.
 */
declare(strict_types=1);
namespace core;

ini_set('display_errors', 1);

use core\Database;
use PDO;

defined('ROOTPATH') or exit . 'Access Denied!';

trait Model
{
    use Database;

    protected $order_column = 'id';
    protected $order_type = 'desc';
    protected $limit = '10';
    private $cache_dir;
    private $cache_expiration;

    public function cache_dir()
    {
        // Modify to root directory.
        $currentDirectory = __DIR__;
        $rootDirectory = dirname($currentDirectory, 2);

        $this->cache_dir = "$rootDirectory/app/cache/";
        $this->cache_expiration = 60 * 60; // 1 hours.
        // example: $this->cache_expiration = 60 * 1; // 1 minuts.
    }

    public function clean_expired_cache()
    {
        $this->cache_dir();

        if (is_dir($this->cache_dir)) {
            foreach (glob("$this->cache_dir*.cache") as $cache_file) {
                if ((time() - filemtime($cache_file)) >= $this->cache_expiration) {
                    unlink($cache_file);
                    // echo "Archivo de caché eliminado: $cache_file<br>";
                }
            }
        }
    }

    // Select all data with cache.
    public function selectAllCache()
    {

        $pdo = $this->get_connection();

        // Execute function to clean expired cache.
        $this->clean_expired_cache();

        /** Select only wanted columns **/
        if (!empty($this->allowdedColumns)) {
            $selectAllowdedColumns = implode(", ", $this->allowdedColumns);
        }

        $query = "select $selectAllowdedColumns from $this->table order by $this->order_column $this->order_type limit $this->limit";

        $cache_key = md5($query);
        $cache_file = "$this->cache_dir$cache_key.cache";

        // Verify is file cache exist.
        if (file_exists($cache_file)) {
            $results = json_decode(file_get_contents($cache_file));
            // echo "Datos obtenidos del caché:<br>";

        } else {

            // Execute query from database.
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_OBJ);

            // Modify to root directory.
            $currentDirectory = __DIR__;
            $rootDirectory = dirname($currentDirectory, 2);

            // Save result in cache.
            if (!is_dir($this->cache_dir)) {
                echo $this->cache_dir;
                if (!mkdir($this->cache_dir, 0777, true)) {
                    file_put_contents("$rootDirectory/app/log/cache.log", "Error:: Can't create cache directory: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
                    die();
                }
            }

            // Create a tempolary file.
            $temp_cache_file = "$cache_file.tmp";
            if (file_put_contents($temp_cache_file, json_encode($results)) === false) {
                file_put_contents("$rootDirectory/app/log/cache.log", "Error:: Can't write in the temporal cache file: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
                die();
            }

            // Rename the temporal cache file.
            if (!rename($temp_cache_file, $cache_file)) {
                file_put_contents("$rootDirectory/app/log/cache.log", "Error:: Can't rename the temporal cache file: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
                die();
            }

            // echo "Datos obtenidos de la base de datos:<br>";
        }

        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $results;
    }

    // Select one data by id with cache.
    public function selectWhereCache($id)
    {

        $pdo = $this->get_connection();

        // Execute function to clean expired cache.
        $this->clean_expired_cache();

        /** Select only wanted columns **/
        if (!empty($this->allowdedColumns)) {
            $selectAllowdedColumns = implode(", ", $this->allowdedColumns);
        }

        $query = "select $selectAllowdedColumns from $this->table where id = :id";

        $cache_key = md5($query);
        $cache_file = "$this->cache_dir $cache_key.cache";

        // Verify is file cache exist.
        if (file_exists($cache_file)) {
            $result = json_decode(file_get_contents($cache_file));
            // echo "Select data ID: $id, from caché:<br>";

        } else {

            // Execute query from database.
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_OBJ);

            // Modify to root directory.
            $currentDirectory = __DIR__;
            $rootDirectory = dirname($currentDirectory, 2);

            // Save result in cache.
            if (!is_dir($this->cache_dir)) {
                echo $this->cache_dir;
                if (!mkdir($this->cache_dir, 0777, true)) {
                    file_put_contents("$rootDirectory/app/log/cache.log", "Error:: Can't create cache directory: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
                    die();
                }
            }

            // Create a tempolary file.
            $temp_cache_file = "$cache_file.tmp";
            if (file_put_contents($temp_cache_file, json_encode($result)) === false) {
                file_put_contents("$rootDirectory/app/log/cache.log", "Error:: Can't write in the temporal cache file: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
                die();
            }

            // Rename the temporal cache file.
            if (!rename($temp_cache_file, $cache_file)) {
                file_put_contents("$rootDirectory/app/log/cache.log", "Error:: Can't rename the temporal cache file: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
                die();
            }

            // echo "Select data ID: $id, from data base:<br>";
        }

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;

    }

    // Select all data with no cache.
    public function selectAll()
    {

        $pdo = $this->get_connection();

        /** Select only wanted columns **/
        if (!empty($this->allowdedColumns)) {
            $selectAllowdedColumns = implode(", ", $this->allowdedColumns);
        }

        $query = "select $selectAllowdedColumns from $this->table order by $this->order_column $this->order_type limit $this->limit";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $results;

    }

    // Select one data by id with no cache.
    public function selectWhere($id)
    {

        $pdo = $this->get_connection();

        /** Select only wanted columns **/
        if (!empty($this->allowdedColumns)) {
            $selectAllowdedColumns = implode(", ", $this->allowdedColumns);
        }

        $query = "select $selectAllowdedColumns from $this->table where id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;

    }

    public function insertData($data)
    {

        $pdo = $this->get_connection();

        /** remove unwanted data **/
        if (!empty($this->allowdedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowdedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        $keys = array_keys($data);

        $query = "insert into $this->table (" . implode(",", $keys) . ") values (:" . implode(",:", $keys) . ")";

        $stmt = $pdo->prepare($query);

        if (isset($data['password'])) {
            $option = [
                'cost' => 12
            ];
            $hashedPwd = password_hash($data['password'], PASSWORD_BCRYPT, $option);
            $data['password'] = $hashedPwd;
        }

        foreach ($keys as $key) {
            $paramName = ':' . $key;
            $stmt->bindParam($paramName, $data[$key]);
        }

        $stmt->execute();
    }

    public function updateData($data, $id)
    {

        $pdo = $this->get_connection();

        /** remove unwanted data **/
        if (!empty($this->allowdedColumns)) {
            foreach ($data as $key => $value) {
                if (!in_array($key, $this->allowdedColumns)) {
                    unset($data[$key]);
                }
            }
        }

        $keys = array_keys($data);

        $setClause = implode("=?, ", $keys) . "=?";
        $query = "update $this->table set $setClause where id = ?";
        $stmt = $pdo->prepare($query);

        $i = 1;
        foreach ($data as $value) {
            $stmt->bindValue($i++, $value);
        }

        $stmt->bindValue($i, $id);

        $stmt->execute();
    }

    public function deleteData($id)
    {

        $pdo = $this->get_connection();
        $query = "delete from $this->table where id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

    }

}