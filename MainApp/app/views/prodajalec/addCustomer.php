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
                            <h1 class=\"registrationHeader\">Dodajanje nove stranke</h1>
                            <label>Ime:</label></br>
                            <input type=\"text\" name=\"ime\"></br>
                
                            <label>Priimek:</label></br>
                            <input type=\"text\" name=\"priimek\"></br>
                
                            <label>Ulica in hišna številka:</label></br>
                            <input type=\"text\" name=\"ulica\"></br>
                
                            <label>Kraj:</label></br>
                            <input type=\"text\" name=\"kraj\"></br>
                
                            <label>Poštna številka:</label></br>
                            <input type=\"text\" name=\"posta\"></br>
                
                            <label>Država:</label></br>
                            <input type=\"text\" name=\"drzava\"></br>
                
                            <label>Email:</label></br>
                            <input type=\"text\" name=\"email\"></br>
                
                            <label>Geslo:</label></br>
                            <input type=\"password\" name=\"geslo\"></br>
                
                            <button type=\"submit\" class=\"editButtonShrani\" name=\"submitStranka\">Dodaj novo stranko</button>
                            <button type=\"submit\" class=\"editButtonNazaj\" name=\"submitBack\">Nazaj</button>
                        </form>
                    </div>
                  </div>";
        } else {
            echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
        }
    } else {
        echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
    }

    if(isset($_POST['submitStranka'])) {
        ProdajalecController::addCustomer($_POST);
    }

    if(isset($_POST['submitBack'])) {
        ViewHelper::redirect('/prodajalec');
    }
?>

<?php include_once('app/views/layouts/footer.php'); ?>
