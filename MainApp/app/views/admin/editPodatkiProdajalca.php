<?php require_once "app/controllers/GetDataController.php"; ?>
<?php include_once('app/views/layouts/header.php'); ?>
<?php
    if(isset($_COOKIE['cookie'])) {
        $uporabnikA = GetDataController::getUser();
        if($uporabnikA['idvloge'] == 'A') {
            if($uporab['idvloge'] == 'P') {
                echo "<div class=\"container\">
                    <div class=\"nav-login\">
                        <form name=\"editForm\" class=\"registrationAndLoginForm\"
                              method=\"post\">
                            <h1 class=\"editHeader\">Spremeni podatke prodajalca</h1>
                            <label>Ime: </label></br>
                            <input type=\"text\" name=\"ime\" value=\""; echo $uporab['ime']; echo "\"></br>
                
                            <label>Priimek: </label></br>
                            <input type=\"text\" name=\"priimek\" value=\""; echo $uporab['priimek']; echo "\"></br>
                
                            <label>Ulica in hišna številka: </label></br>
                            <input type=\"text\" name=\"ulica\" value=\""; echo $uporab['ulica']; echo "\"></br>
                
                            <label>Kraj: </label></br>
                            <input type=\"text\" name=\"kraj\" value=\""; echo $uporab['kraj']; echo "\"></br>
                
                            <label>Poštna številka: </label></br>
                            <input type=\"text\" name=\"posta\" value=\""; echo $uporab['posta']; echo "\"></br>
                
                            <label>Država: </label></br>
                            <input type=\"text\" name=\"drzava\" value=\""; echo $uporab['drzava']; echo "\"></br>
                
                            <label>Elektronski naslov: </label></br>
                            <input type=\"text\" name=\"email\" value=\""; echo $uporab['email']; echo "\"></br>
                
                            <button type=\"submit\" class=\"editButtonShrani\" name=\"submitProdajalecEdit\">Shrani</button>
                            <button type=\"submit\" class=\"editButtonNazaj\" name=\"submitProdajalecBack\">Nazaj</button>
                        </form>
                    </div>
                  </div>";

                if (isset($_POST['submitProdajalecEdit'])) {
                    AdminController::editProdajalec($uporab, $_POST);
                }

                if(isset($_POST['submitProdajalecBack'])) {
                    ViewHelper::redirect('/admin/seller' . DS . $uporab['iduporabnika']);
                }
            } else {
                echo "<h3 style='margin-left: 20px' >Urejanje podatkov tega uporabnika ni dovoljeno!</h3>";
                echo "Nazaj na <a href=\""; echo ROOT_URL . 'admin'; echo"\">konzolo</ahref>";
            }
        } else {
            # User is not logged in and wants to access page profil/edit
            echo "<h3 style='margin-left: 20px' >Za dostop do admin konzole, je potrebna <a href='/login'>prijava</a> z administratorskim računom!</h3>";
        }
    } else {
        # User is not logged in and wants to access page profil/edit
        echo "<h3 style='margin-left: 20px' >Za dostop do admin konzole, je potrebna <a href='/login'>prijava</a> z administratorskim računom!</h3>";
    }
?>
<?php include_once('app/views/layouts/footer.php'); ?>
