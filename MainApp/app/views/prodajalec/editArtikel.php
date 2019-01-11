<?php include_once('app/views/layouts/header.php'); ?>
<?php require_once "app/controllers/GetDataController.php"; ?>
<?php
if(isset($_COOKIE['cookie'])) {
    $uporabnik = GetDataController::getUser();

    if($uporabnik['idvloge'] == 'P') {
        echo "<div class=\"container\">
                <div class=\"nav-login\">
                    <form name=\"editForm\" class=\"registrationAndLoginForm\"
                          method=\"post\">
                        <h1 class=\"editHeader\">Spremeni podatke artikla</h1>
                        <label>Naziv: </label></br>
                        <input type=\"text\" name=\"naziv\" value=\""; echo $arti['naziv']; echo "\"></br>
            
                        <label>Opis: </label></br>
                        <textarea type=\"text\" name=\"opis\" class='txtArea' rows='10' cols='56'>"; echo $arti['opis']; echo"</textarea></br>
            
                        <label>Cena: </label></br>
                        <input type=\"text\" name=\"cena\" value=\""; echo $arti['cena']; echo "\"></br>
            
                        <button type=\"submit\" class=\"editButtonShrani\" name=\"submitArtikelEdit\">Shrani</button>
                        <button type=\"submit\" class=\"editButtonNazaj\" name=\"submitArtikelBack\">Nazaj</button>
                    </form>
                </div>
              </div>";

        if(isset($_POST['submitArtikelEdit'])) {
            ProdajalecController::editArtikelDetails($_POST, $arti['idartikla']);
        }

        if(isset($_POST['submitArtikelBack'])) {
            ViewHelper::redirect(ROOT_URL . 'prodajalec' . DS . 'artikel' . DS . $arti['idartikla'] );
        }
    } else {
        echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
    }
} else {
    echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
}
?>
<?php include_once('app/views/layouts/footer.php'); ?>