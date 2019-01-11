<?php require_once "app/controllers/GetDataController.php"; ?>
<?php include_once('app/views/layouts/header.php'); ?>
<?php
if(isset($_COOKIE['cookie'])) {
    $uporabnik = GetDataController::getUser();

    if($uporabnik['idvloge'] == 'P') {
        echo "<div class=\"container\">
                    <div class=\"nav-login\">
                        <div class=\"adminDiv\">
                            <h1 class=\"prodajalecHeader\">Konzola prodajalca</h1>
                            <h3 class=\"prodajalecHeader\">Stranke</h3>
                            <div class=\"col-md-12\">";
                            foreach ($stranke as $key => $uporabnik):
                                if($uporabnik['idvloge'] == 'S') {
                                    echo "<a href=\""; echo ROOT_URL . 'prodajalec'; echo "\" class=\"btnP\">
                                        <div class=\"prodajalecCard\">
                                            <p>"; echo $uporabnik['ime']; echo " "; echo $uporabnik['priimek']; echo " - ";

                                    if($uporabnik['status'] == '0') {
                                        echo "<a class='deactivate' href=\""; echo ROOT_URL . 'deactivate'. DS . 'seller' . DS . $uporabnik['iduporabnika']; echo"\">Aktiviran</a>";
                                    } else if($uporabnik['status'] == '5') {
                                        echo "<a class='activate' href=\""; echo ROOT_URL . 'activate'. DS . 'seller' . DS . $uporabnik['iduporabnika']; echo"\">Deaktiviran</a>";
                                    } echo "</p>
                                    </div>
                                </a>
                            ";}
                            endforeach;
                            echo "</div>
                            
                            <h3 class=\"prodajalecHeader\">Artikli</h3>
                            <divclass=\"col-md-12\">";
                            foreach ($artikli as $key => $art):

                                echo "<a href=\""; echo ROOT_URL . 'prodajalec'; echo "\" class=\"btnP\">
                                                        <div class=\"prodajalecCard\">
                                                            <p>"; echo $art['naziv']; echo " - ";

                                if($art['status'] == '0') {
                                    echo "<a class='deactivate' href=\""; echo ROOT_URL . 'deactivate'. DS . 'artikel' . DS . $art['idartikla']; echo"\">Aktiviran</a>";
                                } else if($art['status'] == '5') {
                                    echo "<a class='activate' href=\""; echo ROOT_URL . 'activate'. DS . 'artikel' . DS . $art['idartikla']; echo"\">Deaktiviran</a>";
                                } echo "</p>
                                </div>
                                </a>
                            ";
                            endforeach;
                            
                            echo "</div>
                            <a href=\"/prodajalec/customer/add\" class=\"btnP\">
                                <div class=\"addCustomer\">
                                    <b>Dodaj novo stranko</b>
                                </div>
                            </a>
                            <a href=\"/prodajalec/artikel/add\" class=\"btnP\">
                                <div class=\"addArtikel\">
                                    <b>Dodaj nov artikel</b>
                                </div>
                            </a>
                        </div>
                    </div>
                  </div>";
    } else {
        # User is not logged in and wants to access page profil/edit
        echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
    }
} else {
    # User is not logged in and wants to access page profil/edit
    echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
}
?>
<?php include_once('app/views/layouts/footer.php'); ?>