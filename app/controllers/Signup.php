<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use models\Signup as user_signup;

class Signup
{

    use Controller;

    public function index()
    {
        $data = [
            'title' => 'Sign Up',
        ];

        $this->sigun_login_header($data);
        $this->view('signup_login_view/signup', $data);
        $this->sigun_login_footer();
    }

    public function insert_user()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $password_cnfr = $_POST['password_cnfr'];
            $auth_code = md5((string) rand());

            $currentDirectory = __DIR__;
            $newDirectory = dirname($currentDirectory);

            try {
                require $newDirectory . '/core/Validate_data.php';

                $errors = [];

                $data = [
                    'name' => $name,
                    'surname' => $surname,
                    'username' => $username,
                    'email' => $email,
                    'password' => $password,
                    'password_cnfr' => $password_cnfr,
                    'auth_code' => $auth_code
                ];

                $nameSurname = [
                    'name' => $name,
                    'surname' => $surname,
                ];

                if (is_input_empty($data)) {
                    $errors['empty_input'] = 'Some field are empty!';
                }

                if (!are_inputs_contains_allowed_characters($nameSurname)) {
                    $errors['allowed_characters'] = '¡Field name and surname has special character!';
                }

                if (is_username_taken($username)) {
                    $errors['username_taken'] = '¡User name is already taken!';
                }

                if (!validate_email_domain($email)) {
                    $errors['invalid_email_domain'] = '¡This domain are allowded!';
                }

                if (is_email_invalid($email)) {
                    $errors['invalid_email'] = '¡The email are invalid!';
                }

                if (is_email_registered($email)) {
                    $errors['email_used'] = '¡This email was already registered!';
                }

                if (!is_password_match($password, $password_cnfr)) {
                    $errors['password_mismatch'] = '¡Password don\'t match!';
                }

                if (!are_password_secure($password)) {
                    $errors['pwd_validation'] = '¡Your password are not secure: Password must be 8 to 16 characters long, including uppercase letters, special characters, and numbers!';
                }

                if (!are_password_have_minimun_characters($password)) {
                    $errors['pwd_validation_lng'] = '¡Password should have minimun 8 character!';
                }

                if ($errors) {
                    $_SESSION['error_msg'] = $errors;

                    $signupData = [
                        'name' => $name,
                        'surname' => $surname,
                        'username' => $username,
                        'email' => $email
                    ];

                    $_SESSION['signup_data'] = $signupData;
                    header('Location: ' . $_ENV['BASEURL'] . 'signup');
                    die();
                }

                // Envío del correo electrónico de verificación.
                $currentDirectory = __DIR__;
                $newDirectory = dirname($currentDirectory, 2);
                require $newDirectory . '/vendor/autoload.php';

                $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
                $dotenv->safeLoad();

                $mail = new PHPMailer(true);

                // Configuración del servidor SMTP y contenido del correo electrónico.
                // Server settings.
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output.
                $mail->isSMTP();                                           //Send using SMTP.
                $mail->Host = 'smtp.gmail.com';                           //Set the SMTP server to send through.
                $mail->SMTPAuth = true;                                  //Enable SMTP authentication.
                $mail->Username = $_ENV['DATAMAIL'];                    //SMTP username.
                $mail->Password = $_ENV['DATAPASS'];                   //SMTP password.
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;      //Enable implicit TLS encryption.
                $mail->Port = 465;                                   //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`.

                // Recipients.
                $mail->setFrom($_ENV['DATAMAIL']);
                $mail->addAddress($email);

                // Content.
                $mail->isHTML(true);                             //Set email format to HTML
                $mail->Subject = 'no reply';
                $mail->Body = 'Verify your account using this link <b><a href="' . $_ENV['BASEURL'] . 'login/?verification=' . $auth_code . '">' . $_ENV['BASEURL'] . 'login/?verification=' . $auth_code . '</a></b>';

                // Envía el correo electrónico.
                $mail->send();

                // If mail have been send, display user message.
                if ($mail) {

                    $info_msg = [];
                    $info_msg['verify_email'] = "¡Hello $name! Please check your email for the verification link: $email";
                    $_SESSION['info_msg'] = $info_msg;

                    $user = new user_signup;
                    $user->insertData($data);

                    header('Location: ' . $_ENV['BASEURL'] . 'signup');
                    die();
                }

            } catch (PDOException $e) {
                die("Query failds: " . $e->getMessage());
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }

        } else {
            header('Location: ' . $_ENV['BASEURL']);
            die();
        }
    }
}