<?php
declare(strict_types=1);

$currentDirectory = __DIR__;
$newDirectory = dirname($currentDirectory, 2);
require $newDirectory . '/core/Validate_data.php';

if (isset($_GET['verification'])) {

    $auth_code = $_GET['verification'];
    $msg = [];

    if (select_user_verification_code($auth_code)) {
        $msg['auth_code'] = 'Your account has been successfully verified!';
        delete_verification_code($auth_code);
        if ($msg)
            $_SESSION["header_scs_msg"] = $msg;
    } elseif (!user_verification_code_are_empty($auth_code)) {

        $msg['auth_code'] = 'Your account has already been successfully verified! Please enter your details.';
        if ($msg)
            $_SESSION["header_scs_msg"] = $msg;

    } else {
        $msg['error_auth_code'] = 'Upps...! Error with your account verification';
        if ($msg)
            $_SESSION["header_err_msg"] = $msg;
    }
}

if (!isset($_SESSION['user_id'])) { ?>
    <div class="header-msg-container"><?php show_header_msg(); ?></div>
    <div class="scss-msg-container"><?php show_scs_msg(); ?></div>

    <div id="FORM-SYSTEM">
        <form action="<?= URLPATH ?>login/login_user" method="post">
            <div class="form-header">
                <h3>Login</h3>
                <p>Welcome¡ Please write your email and password to login.</p>
            </div>

            <div class="form-inputs-container">

                <div class="form-email-container">
                    <label for="email">email:</label>
                    <input class="form-input-fields" autocomplete="off" type="email" name="email" placeholder="email"
                        value="">
                </div>

                <div class="form-pwd-container">
                    <label for="pwd">password:</label>
                    <div class="form-pwd-input-container">
                        <input class="form-input-fields form-input-pwd pwd" minlength="8" autocomplete="off" type="password"
                            name="password" placeholder="password" value="">
                        <button type="button" class="showPwdBtn">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                </div>
                <a class="web-links" href="<?= URLPATH ?>forgetpwd">forget password?</a>
            </div>

            <button class="form-submit-btn" type="submit">Login</button>
            <div class="links">
                <h3 class="form-link-login">Don't have an account?
                    <a href="<?= URLPATH ?>signup">Create account</a>
                </h3>
                <h3 class="web-terms">Check our <a href="<?= URLPATH ?>terms"> Terms of Service</a> and
                    <a href="<?= URLPATH ?>pp"> Privacy Policy</a>
                </h3>
            </div>
        </form>
    </div>
    <div class="form-error-msg-container"><?php show_err_msg(); ?></div>
<?php } else {
    header('Location: ' . URLPATH);
    die();
} ?>