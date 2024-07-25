<?php
function signup_inputs()
{
    # Name & Surname...
    if (isset($_SESSION['signup_data']['name']) && isset($_SESSION['signup_data']['surname'])) {
        echo '
        <div id="form-name-surname-cont" class="form-name-surname-cont">

            <div class="form-name-container" >
                <label for="name" >name:</label>
                <input id="input_name" class="form-input-fields" maxlength="15" minlength="2" autocomplete="off" type="text" name="name" placeholder="example: john" value="' . $_SESSION['signup_data']['name'] . '">
                <span class="msg_alert msg_alert_input_name"></span>
            </div>

            <div class="form-surname-container">
                <label for="surname" >surname:</label>
                <input id="input_surname" class="form-input-fields" maxlength="15" minlength="2" autocomplete="off" type="text" name="surname" placeholder="example: doe" value="' . $_SESSION['signup_data']['surname'] . '">
                <span class="msg_alert msg_alert_input_surname"></span>
            </div>

        </div>';
    } else {
        echo '
        <div id="form-name-surname-cont" class="form-name-surname-cont">

            <div class="form-name-container" >
                <label for="name" >name:</label>    
                <input id="input_name" class="form-input-fields" maxlength="15" minlength="2" autocomplete="off" type="text" name="name" placeholder="example: john">
                <span class="msg_alert msg_alert_input_name"></span>
            </div>

            <div class="form-surname-container">
                <label for="surname" >surname:</label>
                <input id="input_surname" class="form-input-fields" maxlength="15" minlength="2" autocomplete="off" type="text" name="surname" placeholder="example: doe">
                <span class="msg_alert msg_alert_input_surname"></span>
            </div>

        </div>';
    }
    # User name...
    if (isset($_SESSION['signup_data']['username']) && !isset($_SESSION['errors_signup']['username_used']) && !isset($_SESSION['errors_signup']['invalid_username'])) {

        echo '
        <div class="form-username-container">
            <label for="username" >user name:</label>
            <input id="input_username" class="form-input-fields" maxlength="50" minlength="5" autocomplete="off" type="text" name="username" placeholder="example: johndoe123" value="' . $_SESSION['signup_data']['username'] . '">
            <span class="msg_alert msg_alert_input_username"></span>
       </div>
        ';

    } else {
        echo '
        <div class="form-username-container">
            <label for="username" >user name:</label>
            <input id="input_username" class="form-input-fields" maxlength="50" minlength="5" autocomplete="off" type="username" name="username" placeholder="example: johndoe123">
            <span class="msg_alert msg_alert_input_username"></span>
        </div>
        ';
    }
    # Email...
    if (isset($_SESSION['signup_data']['email']) && !isset($_SESSION['errors_signup']['email_used']) && !isset($_SESSION['errors_signup']['invalid_email'])) {

        echo '
        <div class="form-email-container">
            <label for="email" >email:</label>
            <input id="input_email" class="form-input-fields" maxlength="50" minlength="5" autocomplete="off" type="email" name="email" placeholder="example: johndoe123@mail.com" value="' . $_SESSION['signup_data']['email'] . '">
            <span class="msg_alert msg_alert_input_email"></span>
        </div>
        ';

    } else {
        echo '
        <div class="form-email-container">
            <label for="email" >email:</label>
            <input id="input_email" class="form-input-fields" maxlength="50" minlength="5" autocomplete="off" type="email" name="email" placeholder="example: johndoe123@mail.com">
            <span class="msg_alert msg_alert_input_email"></span>
        </div>
        ';
    }
    # Password...
    echo '
        <div class="form-pwd-container">
            <label for="password" >password:</label>
            <div class="form-pwd-input-container" >
                <input id="input_pwd" class="form-input-fields form-input-pwd pwd" minlength="8"  autocomplete="off" type="password" name="password" placeholder="must be 8 to 16 characters long">
                <button type="button" class="showPwdBtn"><i class="bi bi-eye-slash"></i></button>
            </div>
            <span class="msg_alert msg_alert_input_pwd"></span>
        </div>

        <div class="form-pwd-container">
            <label for="password_cnfr" >confir password:</label>
            <div class="form-pwd-input-container" >
                <input id="input_pwd_confr" class="form-input-fields form-input-pwd pwd_cnfr" minlength="8" autocomplete="off" type="password" name="password_cnfr" placeholder="confir password">
                <button type="button" class="showPwdBtn"><i class="bi bi-eye-slash"></i></button>
            </div>
            <span class="msg_alert msg_alert_input_pwd_confr"></span>
        </div>
    ';
}

if (!isset($_SESSION['user_id'])) { ?>
    <div class="info-msg-container"><?php show_inf_msg(); ?></div>
    <div id="FORM-SYSTEM">
        <form action="<?= URLPATH ?>signup/insert_user" method="post">
            <div class="form-header">
                <h3>Create Account</h3>
                <p>Enter your information to create your account.</p>
            </div>

            <div class="form-inputs-container"><?php signup_inputs(); ?></div>

            <button id="signUp_user" class="form-submit-btn" type="submit">Creat Anccount</button>
            <div class="links">
                <h3 class="form-link-login">Already have an account? <a href="<?= URLPATH ?>login"> Login</a></h3>
                <h3 class="web-terms">By signing up you agree to our <a href="<?= URLPATH ?>terms"> Terms of Service</a> and
                    <a href="<?= URLPATH ?>pp"> Privacy Policy</a>
                </h3>
            </div>
        </form>
    </div>
    <div class="form-error-msg-container"><?php show_err_msg(); ?></div>
<?php } else {
    header('Location:' . URLPATH);
    die();
}