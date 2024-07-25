<?php if (!isset($_SESSION['user_id'])) { ?>
    <div class="info-msg-container"><?php show_inf_msg(); ?></div>
    <div id="FORM-SYSTEM">
        <form action="<?= URLPATH ?>forgetpwd/get_auth_code" method="post">
            <div class="form-header">
                <h3>Forgot password?</h3>
                <p>Enter your email, you will receive a link to reset your password.</p>
            </div>

            <div class="form-inputs-container">
                <div class="form-email-container">
                    <label for="email">email:</label>
                    <input class="form-input-fields" maxlength="50" minlength="5" autocomplete="off" type="email"
                        name="email" placeholder="email">
                </div>
            </div>

            <button class="form-submit-btn" type="submit">Get Link</button>

            <div class="links">
                <h3 class="form-link-login">Remember your password? <a href="<?= URLPATH ?>login"> Login</a>
                </h3>
                <h3 class="form-link-login">Don't have an account? <a href="<?= URLPATH ?>signup"> Create account</a></h3>
                <h3 class="web-terms"><a href="<?= URLPATH ?>terms"> Terms of Service </a> and <a href="<?= URLPATH ?>pp">
                        Privacy Policy</a></h3>
            </div>

            <div class="form-error-msg-container"><?php show_err_msg(); ?></div>
        </form>
    </div>
<?php } else {
    header('Location: ' . URLPATH);
    die();
} ?>
</body>

</html>