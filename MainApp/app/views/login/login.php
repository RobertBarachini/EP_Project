<?php include_once('app/views/layouts/header.php'); ?>
<?php
    if(isset($_POST['submitLogin'])) {
        $email = $_POST['email'];
        $geslo = $_POST['geslo'];

        LoginController::login($email, $geslo);
    }
?>
<div class="container" xmlns="http://www.w3.org/1999/html">
    <div class="nav-login">
        <form name="loginForm" class="registrationAndLoginForm" method="post">
            <h1 class="loginHeader">Prijava</h1>
            <label>Email:</label></br>
            <input type="text" name="email" placeholder="janez@novak.si"></br>

            <label>Geslo:</label></br>
            <input type="password" name="geslo" placeholder="*******"></br>

            <button type="submit" name="submitLogin">Prijava</button></br>
            Še nimate računa? <a href="/register">Registrirajte se</a>
        </form>
    </div>
</div>
<?php include_once('app/views/layouts/footer.php'); ?>
