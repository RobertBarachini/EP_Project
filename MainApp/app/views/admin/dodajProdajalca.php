<?php require_once "app/controllers/GetDataController.php"; ?>
<?php include_once('app/views/layouts/header.php'); ?>

<?php
    if(isset($_COOKIE['cookie'])) {
        $uporabnik = GetDataController::getUser();

        if($uporabnik['idvloge'] == 'A') {
            echo "<div class=\"container\">
                    <div class=\"nav-login\">
                        <form name=\"addSellerForm\" class=\"registrationAndLoginForm\"
                              method=\"post\">
                            <h1 class=\"registrationHeader\">Dodaj prodajalca</h1>
                            <label>Ime:</label></br>
                            <input type=\"text\" name=\"ime\"></br>
                
                            <label>Priimek:</label></br>
                            <input type=\"text\" name=\"priimek\"></br>
                
                            <label>Ulica in hišna številka:</label></br>
                            <input type=\"text\" name=\"ulica\"></br>
                
                            <label>Kraj:</label></br>
                            <input type=\"text\" name=\"kraj\"></br>
                
                            <label>Poštna številka:</label></br>
                            <input type=\"text\" name=\"posta\" ></br>
                
                            <label>Država:</label></br>
                            <input type=\"text\" name=\"drzava\"></br>
                
                            <label>Email:</label></br>
                            <input type=\"text\" name=\"email\"></br>
                
                            <label>Geslo:</label></br>
                            <input type=\"password\" name=\"geslo\"></br>
                
                            <button type=\"submit\" name=\"submitDodaj\" class=\"sellerButtonShrani\">Dodaj</button>
                            <button type=\"submit\" name=\"submitNazaj\" class=\"sellerButtonNazaj\">Nazaj</button>
                        </form>
                    </div>
                  </div>";
        } else {
            # User is not logged in and wants to access page profil/edit
            echo "<h3 style='margin-left: 20px' >Za dostop do admin konzole, je potrebna <a href='/login'>prijava</a> z administratorskim računom!</h3>";
        }

        if(isset($_POST['submitDodaj'])) {
            AdminController::dodajProdajalca($uporabnik, $_POST);
        }

        if(isset($_POST['submitNazaj'])) {
            ViewHelper::redirect('/admin');
        }
    } else {

    }
?>
<?php include_once('app/views/layouts/footer.php'); ?>