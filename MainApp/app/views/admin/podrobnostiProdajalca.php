<?php require_once "app/controllers/GetDataController.php"; ?>
<?php include_once('app/views/layouts/header.php'); ?>
<?php
    if(isset($_COOKIE['cookie'])) {
        $uporabnikAdmin = GetDataController::getUser();
        if($uporabnikAdmin['idvloge'] == 'A') {
            echo "<div class=\"container\">
                <div class=\"album py-5 bg-light\">
                    <div class=\"artikelPage-padd\">
                        <h1>Profil prodajalca</h1>
                        <form action=\""; echo ROOT_URL . 'admin' . DS . 'seller' . DS . $upor['iduporabnika']. DS . 'edit'; echo "\">
                            <button class=\"editProfil\">Spremeni podatke</button>
                        </form>
                        <form action=\""; echo ROOT_URL . 'admin'; echo "\">
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
                                <p><b>Ime: </b>"; echo $upor['ime']; echo "</p>
                                <p><b>Priimek: </b>"; echo $upor['priimek']; echo "</p>
                                <p><b>Ulica in hišna številka: </b>"; echo $upor['ulica']; echo "</p>
                                <p><b>Kraj: </b>"; echo $upor['kraj']; echo "</p>
                                <p><b>Pošta: </b>"; echo $upor['posta']; echo "</p>
                                <p><b>Država: </b>"; echo $upor['drzava']; echo "</p>
                                <p><b>Elektronski naslov: </b>"; echo $upor['email']; echo "</p>
                            </div>
                        </div>
                    </div>
                </div>
              </div>";

        } else {
            # User is not logged in and wants to access page profil/edit
            echo "<h3 style='margin-left: 20px' >Za dostop do admin konzole, je potrebna <a href='/login'>prijava</a> z administratorskim računom!</h3>";
        }
    } else {
        # User is not logged in and wants to access page profil/edit
        echo "<h3 style='margin-left: 20px' >Za dostop do admin konzole, je potrebna <a href='/login'>prijava</a> z administratorskim računom!</h3>";
    }
?>
<div class ="container">

</div>
<?php include_once('app/views/layouts/footer.php'); ?>