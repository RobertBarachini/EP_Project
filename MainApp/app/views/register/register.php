<?php include_once('app/views/layouts/header.php');?>
<?php
    if(isset($_POST['submit'])) {
        RegisterController::preveriVnoseInIzvediRegistracijo($_POST);
    }
?>
<div class="container" xmlns="http://www.w3.org/1999/html">
    <div class="nav-login">
        <form name="registrationForm" class="registrationAndLoginForm"
              method="post">
            <h1 class="registrationHeader">Registracija</h1>
            <label>Ime:</label></br>
            <input type="text" name="ime" placeholder="Janez"></br>

            <label>Priimek:</label></br>
            <input type="text" name="priimek" placeholder="Novak"></br>

            <label>Ulica in hišna številka:</label></br>
            <input type="text" name="ulica" placeholder="Pod gozdom 12b"></br>

            <label>Kraj:</label></br>
            <input type="text" name="kraj" placeholder="Hosta"></br>

            <label>Poštna številka:</label></br>
            <input type="text" name="posta" placeholder="1002"></br>

            <label>Država:</label></br>
            <input type="text" name="drzava" placeholder="Slovenija"></br>

            <label>Email:</label></br>
            <input type="text" name="email" placeholder="janez@novak.si"></br>

            <label>Geslo:</label></br>
            <input type="password" name="geslo" placeholder="*******"></br>

            <button type="submit" name="submit">Registracija</button></br>
            Že imate račun? <a href="/login">Prijavite se</a>
        </form>
    </div>
</div>
<?php include_once('app/views/layouts/footer.php'); ?>
