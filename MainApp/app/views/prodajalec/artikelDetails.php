<?php require_once "app/controllers/GetDataController.php"; ?>
<?php include_once('app/views/layouts/header.php'); ?>
<?php
if(isset($_COOKIE['cookie'])) {
    $uporabnik = GetDataController::getUser();

    if($uporabnik['idvloge'] == 'P') {
            echo "<div class=\"container\">
                    <script>
                        $(document).ready(function () {
                            $('.slider').bxSlider();
                        });
                    </script>
                    <div class=\"album py-5 bg-light\">
                        <div class=\"artikelPage-padd\">
                            <h1>Podrobni podatki artikla</h1>
                            <form action=\""; echo ROOT_URL . 'prodajalec' . DS . 'artikel' . DS . $art['idartikla'] . DS . 'edit'; echo"\">
                                <button class=\"editProfil\">Uredi podatke</button>
                            </form>
                            <form action=\""; echo ROOT_URL . 'prodajalec'; echo "\">
                                <button class=\"editProfil\">Nazaj na konzolo</button>
                            </form>
                            <form action=\""; echo ROOT_URL . 'prodajalec' . DS . 'artikel' . DS . $art['idartikla'] . DS . 'imageAdd'; echo "\">
                                <button class=\"editProfil\"> Dodaj sliko </button>
                            </form>
                            <div class=\"row\">
                                <div class=\"col-md-4\">
                                    <div class=\"card mb-6 shadow-sm \">
                                        <div class=\"slider\">";
                                            foreach ($slike as $key => $pic):
                                                if($pic['idartikla'] == $art['idartikla']) {
                                                    echo "<div>
                                                            <img class=\"card-img-top\"
                                                            src=\"../../images/"; echo $pic['link']; echo "\"
                                                            alt=\"Alt for picture\">
                                                        </div>";
                                                }
                                            endforeach;
                                        echo "</div>
                                    </div>
                                   </div>
                                <div class=\"col-md-6 desc-padd\">
                                    <p><b>Naziv: </b>"; echo $art['naziv']; echo "</p>
                                    <p><b>Opis: </b>"; echo $art['opis']; echo "</p>
                                    <p><b>Cena: </b>"; echo $art['cena']; echo " €</p>
                                </div>
                            </div>
                        </div>
                    </div>
                  </div>";
    } else {
        echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
    }
} else {
    echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
}
?>
<?php include_once('app/views/layouts/footer.php'); ?>
