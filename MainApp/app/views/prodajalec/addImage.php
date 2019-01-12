<?php include_once('app/views/layouts/header.php'); ?>
<?php require_once "app/controllers/GetDataController.php"; ?>
<?php
if(isset($_COOKIE['cookie'])) {
    $uporabnik = GetDataController::getUser();

    if($uporabnik['idvloge'] == 'P') {
        echo "<div class=\"container\">
                <div class=\"nav-login\">
                    <form name=\"editForm\" class=\"registrationAndLoginForm\"
                          method=\"post\" enctype=\"multipart/form-data\">
                        <h1 class=\"editHeader\">Dodaj sliko artiklu</h1>
                        <label>Izberi sliko: </label></br>
                        <input type=\"file\" name=\"image\"></br>
            
                        <label>Ime slike: </label></br>
                        <input type=\"text\" name=\"ime\"></br >
            
                        <input type=\"text\" name=\"id\" hidden='true' value='"; echo $artik['idartikla']; echo "'></br>
            
                        <button type=\"submit\" class=\"editButtonShrani\" name=\"submitArtikelEdit\">Shrani</button>
                        <button type=\"submit\" class=\"editButtonNazaj\" name=\"submitArtikelBack\">Nazaj</button>
                    </form>
                </div>
              </div>";

        if(isset($_POST['submitArtikelEdit'])) {
            ProdajalecController::addImage($_POST, $_FILES, $artik);
        }

        if(isset($_POST['submitArtikelBack'])) {
            ViewHelper::redirect(ROOT_URL . 'prodajalec' . DS . 'artikel' . DS . $artik['idartikla'] );
        }
    } else {
        echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
    }
} else {
    echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
}
?>
<?php include_once('app/views/layouts/footer.php'); ?>