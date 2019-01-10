<?php include_once('app/views/layouts/header.php'); ?>
<?php
    if(isset($_COOKIE['cookie'])) {
        echo "<div class=\"container\">
                <div class=\"nav-login\">
                    <form name=\"pwdForm\" class=\"registrationAndLoginForm\"
                          method=\"post\">
                        <h1 class=\"editHeader\">Spremeni geslo</h1>
            
                        <label>Staro geslo:</label></br>
                        <input type=\"password\" name=\"staro\"></br>
            
                        <label>Novo geslo:</label></br>
                        <input type=\"password\" name=\"novo1\"></br>
            
                        <label>Ponovi novo geslo:</label></br>
                        <input type=\"password\" name=\"novo2\"></br>
            
                        <button type=\"submit\" class=\"editButtonShrani\" name=\"submitPassword\">Shrani</button>
                        <button type=\"submit\" class=\"editButtonNazaj\" name=\"submitBack\">Nazaj</button>
                    </form>
                </div>
            </div>";

        if(isset($_POST['submitPassword'])) {
            ProfilController::changePassword($_POST);
        }

        if(isset($_POST['submitBack'])) {
            ViewHelper::redirect('/profil');
        }
    } else {
        echo "<h3 style='margin-left: 20px'>Za dostop do spreminjanja gesla uporabnika, je potrebna <a href='/login'>prijava</a>!</h3>";
    }
?>
<?php include_once('app/views/layouts/footer.php'); ?>
