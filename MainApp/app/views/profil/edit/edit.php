<?php include_once('app/views/layouts/header.php'); ?>
<?php
    if(isset($_COOKIE['cookie'])) {
        $uporabnik = requestUtil::sendRequest('http://localhost/trgovina/api/v1/uporabniki/read_one_piskotek.php'  . '?piskotek=' . $_COOKIE['cookie'], "GET", "");
        $berljiviPodatki = json_encode($uporabnik);
        $decodiraniPodatki = json_decode($berljiviPodatki,true);

        if($uporabnik == null) {

        } else {
            # If button to save is clicked
            if(isset($_POST['submitEdit'])) {
                ProfilController::editProfil($decodiraniPodatki, $_POST);
            }

            # If button for back is clicked
            if(isset($_POST['submitBack'])) {
                ViewHelper::redirect('/profil');
            }
        }

    }

?>
<div class="container">
    <div class="nav-login">
        <form name="editForm" class="registrationAndLoginForm"
              method="post">
            <h1 class="editHeader">Spremeni osebne podatke</h1>
            <label>Ime:</label></br>
            <input type="text" name="ime" value="<?php echo $decodiraniPodatki['ime']?>"></br>

            <label>Priimek:</label></br>
            <input type="text" name="priimek" value="<?php echo $decodiraniPodatki['priimek']?>"></br>

            <label>Ulica in hišna številka:</label></br>
            <input type="text" name="ulica" value="<?php echo $decodiraniPodatki['ulica']?>"></br>

            <label>Kraj:</label></br>
            <input type="text" name="kraj" value="<?php echo $decodiraniPodatki['kraj']?>"></br>

            <label>Poštna številka:</label></br>
            <input type="text" name="posta" value="<?php echo $decodiraniPodatki['posta']?>"></br>

            <label>Država:</label></br>
            <input type="text" name="drzava" value="<?php echo $decodiraniPodatki['drzava']?>"></br>

            <label>Elektronski naslov:</label></br>
            <input type="text" name="email" value="<?php echo $decodiraniPodatki['email']?>"></br>

            <button type="submit" class="editButtonShrani" name="submitEdit">Shrani</button>
            <button type="submit" class="editButtonNazaj" name="submitBack">Nazaj</button>
        </form>
    </div>
</div>

<?php include_once('app/views/layouts/footer.php'); ?>
