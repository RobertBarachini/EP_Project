<?php require_once "app/controllers/GetDataController.php"; ?>
<?php include_once('app/views/layouts/header.php'); ?>
<?php
    if(isset($_COOKIE['cookie'])) {
        $uporabnik = GetDataController::getUser();
        if($uporabnik['idvloge'] == 'P') {
            echo "<div class=\"container\" xmlns=\"http://www.w3.org/1999/html\">
                        <div class=\"nav-login\">
                            <form name=\"addCustomerForm\" class=\"registrationAndLoginForm\"
                                  method=\"post\">
                                <h1 class=\"registrationHeader\">Dodajanje novega artikla</h1>
                                <label>Naziv:</label></br>
                                <input type=\"text\" name=\"naziv\" placeholder='Lesena omara'></br>
                    
                                <label>Opis:</label></br>
                                <textarea type=\"text\" class='txtArea' name=\"opis\" rows='10' cols='56' placeholder='Malo stara, ampak zelo dobra'></textarea></br>
                    
                                <label>Cena:</label></br>
                                <input type=\"text\" name=\"cena\" placeholder='350.0'></br>
                    
                                <button type=\"submit\" class=\"editButtonShrani\" name=\"submitArtikel\">Dodaj nov artikel</button>
                                <button type=\"submit\" class=\"editButtonNazaj\" name=\"submitArtBack\">Nazaj</button>
                            </form>
                        </div>
                      </div>";

            if(isset($_POST['submitArtikel'])) {
                ProdajalecController::addArtikel($_POST);
            }

            if(isset($_POST['submitArtBack'])) {
                ViewHelper::redirect('/prodajalec');
            }
        } else {
            echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
        }
    } else {
        echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
    }
?>

<?php include_once('app/views/layouts/footer.php'); ?>