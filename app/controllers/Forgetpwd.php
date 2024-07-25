<?php
declare(strict_types=1);
defined('ROOTPATH') or exit('Access Denied!');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Forgetpwd
{
    use Controller;

    public function index()
    {
        $data = [
            'title' => 'Forget password',
        ];

        $this->sigun_login_header($data);
        $this->view('signup_login_view/forgetpwd', $data);
        $this->sigun_login_footer();
    }

    public function get_auth_code()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $auth_code = md5((string) rand());

            $currentDirectory = __DIR__;
            $newDirectory = dirname($currentDirectory);

            try {

                require $newDirectory . '/core/Validate_data.php';

                $errors = [];

                $data = [
                    'email' => $email,
                ];

                if (is_input_empty($data)) {
                    $errors['empty_input'] = 'Please enter your email!';
                }

                if (is_email_wrong($email)) {
                    $errors['email_used'] = 'The mail entered was not found!';
                }

                if ($errors) {
                    $_SESSION['error_msg'] = $errors;

                    header('Location: ' . $_ENV['BASEURL'] . 'forgetpwd');
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
                $mail->Body = 'Click on this link to log in. <b><a href="' . $_ENV['BASEURL'] . 'resetpass/?verification=' . $auth_code . '">' . $_ENV['BASEURL'] . 'resetpass/?verification=' . $auth_code . '</a></b>';

                // Envía el correo electrónico.
                $mail->send();

                // If mail have been send, display user message.
                if ($mail) {

                    $info_msg = [];
                    $info_msg['verify_email'] = "Hello! We have sent you a link to your email: $email, to reset password.";
                    $_SESSION['info_msg'] = $info_msg;

                    $auth_code_data = ['auth_code' => $auth_code];
                    $_SESSION['auth_code_data'] = $auth_code_data;

                    update_user_code($email, $auth_code);

                    header('Location: ' . $_ENV['BASEURL'] . 'forgetpwd');
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