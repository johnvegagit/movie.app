<?php
declare(strict_types=1);

namespace core;

use PDO;
use PDOException;

defined('ROOTPATH') or exit('Access Denied!');

trait Database
{
    private $dbhost;
    private $dbname;
    private $dbuser;
    private $dbpass;

    public function __construct()
    {
        $this->dbhost = $_ENV['DBHOST'];
        $this->dbname = $_ENV['DBNAME'];
        $this->dbuser = $_ENV['DBUSER'];
        $this->dbpass = $_ENV['DBPASS'];
    }

    public function get_connection(): PDO
    {
        try {
            $pdo = new PDO("mysql:host=$this->dbhost;dbname=$this->dbname", $this->dbuser, $this->dbpass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

}
