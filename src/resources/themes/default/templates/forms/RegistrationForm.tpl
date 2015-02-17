<form method="post" action="register.php">
    <h3>Register</h3>
    <div id="holder">
        <div id="page_1" class="form-page">
            <fieldset id="inputs">
                <input id="username" name="username" type="text" placeholder="Username">
                <input id="email" name="email" type="text" placeholder="Email">
                <input id="password" name="password" type="password" placeholder="Password">
                <input id="c_password" name="c_password" type="password" placeholder="Confirm Password">
                { form->captcha }
                <br />
                <input id="captcha" name="captcha" type="text" placeholder="Enter characters above">
            </fieldset>
            <fieldset id="links">
                <input type="submit" class="submit" name="register" value="Register">
                <label id="other">Have an account? <a href="login.php">Login</a></label>
            </fieldset>
        </div>
    </div>
</form>