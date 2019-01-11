<?php include_once('app/views/layouts/header.php'); ?>
<?php require_once "app/controllers/GetDataController.php"; ?>
<?php
    if(isset($_COOKIE['cookie'])) {
        $uporabnik = GetDataController::getUser();

        if($uporabnik['idvloge'] == 'P') {
            if($usr['idvloge'] == 'S') {
                echo "<div class=\"container\">
                    <div class=\"album py-5 bg-light\">
                        <div class=\"artikelPage-padd\">
                            <h1>Podrobni podatki stranke</h1>
                            <form action=\""; echo ROOT_URL . 'prodajalec' . DS . 'customer' . DS . $usr['iduporabnika'] . DS . 'edit'; echo"\">   
                                <button class=\"editProfil\">Uredi podatke</button>
                            </form>
                            <form action=\""; echo ROOT_URL . 'prodajalec'; echo "\">
                                <button class=\"editProfil\">Nazaj na konzolo</button>
                            </form>
                            <div class=\"row\">
                                <div class=\"col-md-4\">
                                    <div class=\"card mb-6 shadow-sm\">
                                        <img class=\"card-img-top\"
                                             src=\"https://www.sioug.si/images/SIOUG/2016_SIOUG/Java_si_predavatelji/unknown-user.png\"
                                             alt=\"Alt for picture\">
                                    </div>
                                </div>
                                <div class=\"col-md-6 desc-padd\">
                                    <p><b>Ime: </b>"; echo $usr['ime']; echo "</p>
                                    <p><b>Priimek: </b>"; echo $usr['priimek']; echo "</p>
                                    <p><b>Ulica in hišna številka: </b>"; echo $usr['ulica']; echo "</p>
                                    <p><b>Kraj: </b>"; echo $usr['kraj']; echo "</p>
                                    <p><b>Pošta: </b>"; echo $usr['posta']; echo "</p>
                                    <p><b>Država: </b>"; echo $usr['drzava']; echo "</p>
                                    <p><b>Elektronski naslov: </b>"; echo $usr['email']; echo "</p>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>";
            } else {
                echo "<h3 style='margin-left: 20px' >Vpogled v podatke tega uporabnika ni dovoljeno!</h3>";
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
