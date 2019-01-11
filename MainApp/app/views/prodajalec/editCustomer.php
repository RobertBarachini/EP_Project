<?php include_once('app/views/layouts/header.php'); ?>
<?php require_once "app/controllers/GetDataController.php"; ?>
<?php
    if(isset($_COOKIE['cookie'])) {
        $uporabnik = GetDataController::getUser();

        if($uporabnik['idvloge'] == 'P') {
            if($user['idvloge'] == 'S'){
                echo "<div class=\"container\">
                    <div class=\"nav-login\">
                        <form name=\"editForm\" class=\"registrationAndLoginForm\"
                              method=\"post\">
                            <h1 class=\"editHeader\">Spremeni osebne podatke</h1>
                            <label>Ime: </label></br>
                            <input type=\"text\" name=\"ime\" value=\""; echo $user['ime']; echo "\"></br>
                
                            <label>Priimek: </label></br>
                            <input type=\"text\" name=\"priimek\" value=\""; echo $user['priimek']; echo "\"></br>
                
                            <label>Ulica in hišna številka: </label></br>
                            <input type=\"text\" name=\"ulica\" value=\""; echo $user['ulica']; echo "\"></br>
                
                            <label>Kraj: </label></br>
                            <input type=\"text\" name=\"kraj\" value=\""; echo $user['kraj']; echo "\"></br>
                
                            <label>Poštna številka: </label></br>
                            <input type=\"text\" name=\"posta\" value=\""; echo $user['posta']; echo "\"></br>
                
                            <label>Država: </label></br>
                            <input type=\"text\" name=\"drzava\" value=\""; echo $user['drzava']; echo "\"></br>
                
                            <label>Elektronski naslov: </label></br>
                            <input type=\"text\" name=\"email\" value=\""; echo $user['email']; echo "\"></br>
                
                            <button type=\"submit\" class=\"editButtonShrani\" name=\"submitCustomerEdit\">Shrani</button>
                            <button type=\"submit\" class=\"editButtonNazaj\" name=\"submitCustomerBack\">Nazaj</button>
                        </form>
                    </div>
                  </div>";

                if(isset($_POST['submitCustomerEdit'])) {
                    ProdajalecController::editCustomerDetails($_POST, $user['iduporabnika']);
                }

                if(isset($_POST['submitCustomerBack'])) {
                    ViewHelper::redirect(ROOT_URL . 'prodajalec' . DS . 'customer' . DS . $user['iduporabnika'] );
                }
            } else {
                echo "<h3 style='margin-left: 20px' >Urejanje podatkov tega uporabnika ni dovoljeno!</h3>";
                echo "Nazaj na <a href=\""; echo ROOT_URL . 'prodajalec'; echo"\">konzolo</ahref>";
            }
        } else {
            echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
        }
    } else {
        echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
    }
?>
<?php include_once('app/views/layouts/footer.php'); ?>