<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

$currentDirectory = __DIR__;
$newDirectory = dirname($currentDirectory, 2);
require $newDirectory . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
$dotenv->safeLoad();

class Login
{

    use Controller;

    public function index()
    {

        $data = [
            'title' => 'Log In',
        ];

        $this->sigun_login_header($data);
        $this->view('signup_login_view/login', $data);
        $this->sigun_login_footer();

    }

    public function login_user()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = $_POST['email'];
            $password = $_POST['password'];

            $currentDirectory = __DIR__;
            $newDirectory = dirname($currentDirectory);
            echo $newDirectory;
            try {
                require $newDirectory . '/core/Validate_data.php';

                // ERROR HANDLER...
                $errors = [];

                $data = [
                    'email' => $email,
                    'password' => $password,
                ];

                $get_data = get_user_data($email);

                if (is_input_empty($data)) {
                    $errors['empty_input'] = 'Some fields are empty!';
                }

                if (is_user_email_wrong($email)) {
                    $errors['login_incorrect'] = 'Incorrect data!';
                }

                if (!is_user_email_wrong($email) && is_password_wrong($password, $email)) {
                    $errors['login_incorrect'] = 'Incorrect data!';
                }

                if (is_user_verify($email)) {
                    $errors['user_are_verify'] = 'You haven\'t verified your account yet. Check your email!';
                }

                if ($errors) {
                    $_SESSION['error_msg'] = $errors;

                    header('Location: ' . $_ENV['BASEURL'] . 'login');
                    die();
                }

                $newSessionId = session_create_id();
                $sessionId = $newSessionId . "_" . $get_data->id;
                session_id($sessionId);

                /** saved in session */
                $_SESSION["user_id"] = $get_data->id;
                $_SESSION["user_name"] = htmlspecialchars($get_data->name);
                $_SESSION["user_surname"] = htmlspecialchars($get_data->surname);
                $_SESSION["user_email"] = htmlspecialchars($get_data->email);

                $_SESSION["last_regeneration"] = time();

                header('Location: ' . $_ENV['BASEURL']);
                die();

            } catch (PDOException $e) {
                die("Query failds: " . $e->getMessage());
            }

        } else {
            header('Location: ' . $_ENV['BASEURL']);
            die();
        }
    }
}