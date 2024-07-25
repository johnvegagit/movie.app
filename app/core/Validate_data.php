<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

/**
 * Data validation functions.
 */

use core\Database;

class Validate_data
{
    use Database;

    public function validate_data_func()
    {
        $pdo = $this->get_connection();
        return $pdo;
    }

    public function get_email(string $email)
    {
        $pdo = $this->get_connection();
        $query = "select * from users where email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function get_username(string $username)
    {
        $pdo = $this->get_connection();
        $query = "select * from users where username = :username";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function get_hashedPwd($email)
    {
        $pdo = $this->get_connection();
        $query = "select password from users where email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function user_verification_code_are_empty($email)
    {

        $pdo = $this->get_connection();
        $query = "select auth_code from users where email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;

    }

    public function check_user_verification_code_exist($auth_code)
    {

        $pdo = $this->get_connection();
        $query = "select auth_code from users where auth_code = :auth_code";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':auth_code', $auth_code);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;

    }

    public function check_user_verification_code_are_empty($auth_code)
    {

        $pdo = $this->get_connection();
        $query = "select auth_code from users where auth_code = :auth_code";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':auth_code', $auth_code);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;

    }

    public function delete_verification_code_db($auth_code)
    {

        $pdo = $this->get_connection();
        $query = "UPDATE users SET auth_code = '' WHERE auth_code = :auth_code";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":auth_code", $auth_code);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;

    }

    public function get_user_data_from_db($email)
    {

        $pdo = $this->get_connection();
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;

    }

    public function update_user($email, $auth_code)
    {
        $pdo = $this->get_connection();
        $query = "UPDATE users SET auth_code = :auth_code WHERE email = :email";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":auth_code", $auth_code);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }

    public function update_user_reset($password, $auth_code)
    {
        $pdo = $this->get_connection();
        $query = "UPDATE users SET password = :password, auth_code = '' WHERE auth_code = :auth_code";
        $stmt = $pdo->prepare($query);

        $option = [
            'cost' => 12
        ];
        $hashedpassword = password_hash($password, PASSWORD_BCRYPT, $option);

        $stmt->bindParam(":password", $hashedpassword);
        $stmt->bindParam(":auth_code", $auth_code);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;

    }
}

# - Check if inputs are empty.
function is_input_empty(array $data)
{

    foreach ($data as $key => $value) {

        if (empty(trim($value))) {
            return true;
        }
    }

}

# - Check if inputs contains onlly allowded characters.
function are_inputs_contains_allowed_characters(array $nameSurname)
{

    foreach ($nameSurname as $key => $value) {

        if (preg_match('/^[a-zA-Z0-9_]+$/', $value)) {
            return true;
        }
        return false;
    }
}

function is_username_taken(string $username)
{

    $get_bol = new Validate_data;
    $torf = $get_bol->get_username($username);

    if ($torf) {
        return true;
    } else {
        return false;
    }
}

# - Check if input are empty. Use this if function to validate signup/login.
function is_input_empty_for_signup_user(string $email, ?string $pwd = null, ?string $name = null, ?string $surname = null, ?string $pwd_cnfr = null)
{

    if (empty($email)) {
        return true; // If email have data, return true.
    }

    if (!is_null($name) && !is_null($surname) && !is_null($pwd) && !is_null($pwd_cnfr)) {
        if (empty($name) || empty($surname) || empty($pwd) || empty($pwd_cnfr)) {
            return true; // If inputs from signup/login are empty, return true.
        }
    }

    return false; // inputs have data, return false.

}

# - Validate email domain.
function validate_email_domain(string $email)
{

    $partes = explode('@', $email);
    $dominio = end($partes);

    $dominiosPermitidos = array('gmail.com', 'hotmail.com', 'outlook.com');

    if (in_array($dominio, $dominiosPermitidos)) {
        return true;
    } else {
        return false;
    }

}

# - Email validation.
function is_email_invalid(string $email)
{

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }

}

# - check if email are already exist in db.
function is_email_registered(string $email)
{

    $get_bol = new Validate_data;
    $torf = $get_bol->get_email($email);

    if ($torf) {
        return true;
    } else {
        return false;
    }

}

# - Check if password match whit confirm password.
function is_email_wrong(string $email)
{

    $get_bol = new Validate_data;
    $torf = $get_bol->get_email($email);

    if (!$torf) {
        return true;
    } else {
        return false;
    }

}

# - Check if password match whit confirm password.
function is_password_match(string $password, string $password_cnfr)
{
    if ($password === $password_cnfr) {
        return true;
    } else {
        return false;
    }
}


# - Check if password are secure.
function are_password_secure($password)
{
    if (
        !preg_match('/[a-z]/', $password) || !preg_match('/[A-Z]/', $password) ||
        !preg_match('/[0-9]/', $password) || !preg_match('/[^a-zA-Z0-9]/', $password)
    ) {
        return false;
    }

    return true;
}

# - Check if password is atleast 8 characters minimun.
function are_password_have_minimun_characters($password)
{
    if (strlen($password) < 8) {
        return false;
    }

    return true;
}

# - Get user verification code.
function select_user_verification_code(string $auth_code)
{

    $get_bol = new Validate_data;
    $torf = $get_bol->check_user_verification_code_exist($auth_code);

    if ($torf) {
        return true;
    } else {
        return false;
    }

}

function is_user_code_wrong(string $auth_code)
{

    $get_bol = new Validate_data;
    $torf = $get_bol->check_user_verification_code_are_empty($auth_code);

    if (!$torf) {
        return true;
    } else {
        return false;
    }

}

# - Check if user verifcation code are empty.
function user_verification_code_are_empty(string $auth_code)
{

    $get_bol = new Validate_data;
    $torf = $get_bol->check_user_verification_code_are_empty($auth_code);

    if ($torf) {
        return true;
    } else {
        return false;
    }

}

# - Delete user verification code.
function delete_verification_code(string $auth_code)
{

    $get_bol = new Validate_data;
    $torf = $get_bol->delete_verification_code_db($auth_code);

    if ($torf) {
        return true;
    } else {
        return false;
    }

}

# - At login check if user email are wrong.
function is_user_email_wrong(string $email)
{

    $get_bol = new Validate_data;
    $torf = $get_bol->get_email($email);

    if (!$torf) {
        return true;
    } else {
        return false;
    }

}

# - Check if password are wrong, pwd and hashedPwd should be equal.
function is_password_wrong(string $password, string $email)
{

    $get_bol = new Validate_data;
    $torf = $get_bol->get_hashedPwd($email);

    if (!password_verify($password, $torf->password)) {
        return true;
    } else {
        return false;
    }

}

# - Check if user are verify, check if code in db are empty.
function is_user_verify(string $email)
{

    $get_bol = new Validate_data;
    $torf = $get_bol->user_verification_code_are_empty($email);
    //showPre($torf);
    if ($torf->auth_code) {
        return true;
    } else {
        return false;
    }

}

# - Get user data.
function get_user_data($email)
{
    $user_data = new Validate_data;
    $data = $user_data->get_user_data_from_db($email);
    return $data;
}

// forget pass
function update_user_code(string $email, string $auth_code)
{

    $get_bol = new Validate_data;
    $torf = $get_bol->update_user($email, $auth_code);
    if ($torf->auth_code) {
        return true;
    } else {
        return false;
    }

}

// Reset pass.
function is_user_code_empty(string $code)
{
    if (empty($code)) {
        return true;
    } else {
        return false;
    }
}

function update_user_reset_code(string $password, string $auth_code)
{

    $get_bol = new Validate_data;
    $torf = $get_bol->update_user_reset($password, $auth_code);
    if ($torf->auth_code) {
        return true;
    } else {
        return false;
    }

}