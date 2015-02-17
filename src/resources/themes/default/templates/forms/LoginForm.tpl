<form method="post" action="login.php">
    <h3>Login</h3>
    <div id="holder">
        <div id="page_1" class="form-page">
            <fieldset id="inputs">
                <input id="username" name="username" type="text" placeholder="Username or Email">
                <input id="password" name="password" type="password" placeholder="Password">
                { form->captcha }
                <br />
                <input id="captcha" name="captcha" type="text" placeholder="Enter characters above">
            </fieldset>
            <fieldset id="links">
                <input type="submit" class="submit" name="login" value="Login">
                <label id="other">Need an account? <a href="register.php">Register</a></label>
            </fieldset>
        </div>
    </div>
</form>