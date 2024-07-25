<?php
declare(strict_types=1);

namespace models;

use core\Model;

defined('ROOTPATH') or exit('Access Denied!');

class Signup
{

    use Model;

    protected $table = 'users';
    protected $id = 'id';
    protected $allowdedColumns = [

        "name",
        "surname",
        "username",
        "email",
        "password",
        "auth_code"

    ];
}