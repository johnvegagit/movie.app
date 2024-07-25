<?php
function get_session_code()
{
    if (isset($_SESSION['auth_code_data'])) {
        echo '
            <input type="text" hidden name="auth_code" value="' . $_SESSION['auth_code_data']['auth_code'] . '">
        ';
    } else {
        echo 'An error has occurred. Re-enter the link sent to your email.';
    }
}

if (!isset($_SESSION['user_id'])) { ?>
    <div id="FORM-SYSTEM">
        <form action="<?= URLPATH ?>resetpass/r" method="post">
            <div class="form-header">
                <h3>Reset password!</h3>
                <p>Password must be 8 to 16 characters long, including uppercase letters,
                    special characters, and numbers.
                </p>
            </div>
            <div class="form-inputs-container">
                <?php get_session_code(); ?>
                <div class="form-pwd-container">
                    <label for="pwd">password:</label>
                    <div class="form-pwd-input-container">
                        <input class="form-input-fields form-input-pwd pwd" minlength="8" autocomplete="off" type="password"
                            name="password" placeholder="must be 8 to 16 characters">
                        <button type="button" class="showPwdBtn"><i class="bi bi-eye-slash"></i></button>
                    </div>
                </div>

                <div class="form-pwd-container">
                    <label for="pwd_cnfr">confirm password:</label>
                    <div class="form-pwd-input-container">
                        <input class="form-input-fields form-input-pwd pwd_cnfr" minlength="8" autocomplete="off"
                            type="password" name="password_cnfr" placeholder="confirm password">
                        <button type="button" class="showPwdBtn"><i class="bi bi-eye-slash"></i></button>
                    </div>
                </div>
            </div>

            <button class="form-submit-btn" type="submit">Submit change</button>
            <h3 class="web-terms">
                <a href="<?= URLPATH ?>terms"> Terms of Service </a> and <a href="<?= URLPATH ?>pp"> Privacy Policy</a>
            </h3>
            <div class="form-error-msg-container"><?php show_err_msg(); ?></div>
        </form>
    </div>
<?php } else {
    header('Location: ' . URLPATH);
    die();
} ?>
</body>

</html>