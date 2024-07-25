<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

$currentDirectory = __DIR__;
$newDirectory = dirname($currentDirectory, 2);
require $newDirectory . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->safeLoad();

class Resetpass
{

    use Controller;

    public function index()
    {
        $data = [
            'title' => 'Reset password',
        ];

        $this->sigun_login_header($data);
        $this->view('signup_login_view/resetpass', $data);
        $this->sigun_login_footer();

    }

    public function r()
    {

        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            $password = $_POST['password'];
            $password_cnfr = $_POST['password_cnfr'];
            $auth_code = $_POST['auth_code'];

            $currentDirectory = __DIR__;
            $newDirectory = dirname($currentDirectory);

            try {

                require $newDirectory . '/core/Validate_data.php';

                $errors = [];

                $data = [
                    'password' => $password,
                    'password_cnfr' => $password_cnfr,
                ];

                if (is_input_empty($data)) {
                    $errors['empty_input'] = 'Empty fields! Enter a new password.';
                }

                if (is_user_code_empty($auth_code)) {
                    $errors['empty_code'] = 'An error has occurred with the code!';
                }

                if (is_user_code_wrong($auth_code)) {
                    $errors['empty_code'] = 'An error has occurred with the code!';
                }

                if (!is_password_match($password, $password_cnfr)) {
                    $errors['pwd_mismatch'] = 'Passwords don\'t match!';
                }

                if ($errors) {
                    $_SESSION['error_msg'] = $errors;

                    header('Location: ' . $_ENV['BASEURL'] . 'resetpass');
                    die();
                }

                update_user_reset_code($password, $auth_code);

                $scss_msg = [];
                $scss_msg['restpwd_scs'] = "Your password has been successfully restored.";
                $_SESSION['scss_msg'] = $scss_msg;

                header('Location: ' . $_ENV['BASEURL'] . 'login/?resetpass=success');
                die();

            } catch (PDOException $e) {
                die("Query failds: " . $e->getMessage());
            }
        }
    }
}