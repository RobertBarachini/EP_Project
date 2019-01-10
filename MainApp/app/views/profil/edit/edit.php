<?php include_once('app/views/layouts/header.php'); ?>
<?php
    if(isset($_COOKIE['cookie'])) {
        $uporabnik = requestUtil::sendRequest('http://localhost/trgovina/api/v1/uporabniki/read_one_piskotek.php'  . '?piskotek=' . $_COOKIE['cookie'], "GET", "");
        $berljiviPodatki = json_encode($uporabnik);
        $decodiraniPodatki = json_decode($berljiviPodatki,true);

        if($uporabnik == null) {
            # User wants to use fake cookie --> user is not found in database
            echo "<h3 style='margin-left: 20px' >Ne najdem uporabnika s tem piškotkom!</h3>";
        } else {
            echo "<div class=\"container\">
                    <div class=\"nav-login\">
                        <form name=\"editForm\" class=\"registrationAndLoginForm\"
                              method=\"post\">
                            <h1 class=\"editHeader\">Spremeni osebne podatke</h1>
                            <label>Ime: </label></br>
                            <input type=\"text\" name=\"ime\" value=\""; echo $decodiraniPodatki['ime']; echo "\"></br>
                
                            <label>Priimek: </label></br>
                            <input type=\"text\" name=\"priimek\" value=\""; echo $decodiraniPodatki['priimek']; echo "\"></br>
                
                            <label>Ulica in hišna številka: </label></br>
                            <input type=\"text\" name=\"ulica\" value=\""; echo $decodiraniPodatki['ulica']; echo "\"></br>
                
                            <label>Kraj: </label></br>
                            <input type=\"text\" name=\"kraj\" value=\""; echo $decodiraniPodatki['kraj']; echo "\"></br>
                
                            <label>Poštna številka: </label></br>
                            <input type=\"text\" name=\"posta\" value=\""; echo $decodiraniPodatki['posta']; echo "\"></br>
                
                            <label>Država: </label></br>
                            <input type=\"text\" name=\"drzava\" value=\""; echo $decodiraniPodatki['drzava']; echo "\"></br>
                
                            <label>Elektronski naslov: </label></br>
                            <input type=\"text\" name=\"email\" value=\""; echo $decodiraniPodatki['email']; echo "\"></br>
                
                            <button type=\"submit\" class=\"editButtonShrani\" name=\"submitEdit\">Shrani</button>
                            <button type=\"submit\" class=\"editButtonNazaj\" name=\"submitBack\">Nazaj</button>
                        </form>
                    </div>
                  </div>";


            # If button to save is clicked
            if(isset($_POST['submitEdit'])) {
                ProfilController::editProfil($decodiraniPodatki, $_POST);
            }

            # If button for back is clicked
            if(isset($_POST['submitBack'])) {
                ViewHelper::redirect('/profil');
            }
        }
    } else {
        # User is not logged in and wants to access page profil/edit
        echo "<h3 style='margin-left: 20px' >Za dostop do urejanja podatkov uporabnika, je potrebna <a href='/login'>prijava</a>!</h3>";
    }
?>
<?php include_once('app/views/layouts/footer.php'); ?>
