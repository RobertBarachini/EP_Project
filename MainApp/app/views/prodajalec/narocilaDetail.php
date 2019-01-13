<?php include_once('app/views/layouts/header.php'); ?>
<?php require_once "app/controllers/GetDataController.php"; ?>
<?php
if(isset($_COOKIE['cookie'])) {
    $uporabnik = GetDataController::getUser();

    if($uporabnik['idvloge'] == 'P') {
        echo "<div class=\"container\">
                    <div class=\"album py-5 bg-light\">
                        <div class=\"artikelPage-padd\">
                            <h1>Podrobni podatki naročila</h1>
                            <div class=\"row\">
                                <div class=\"col-md-4\">
                                    <h3>Podatki o naročniku</h3>
                                    <p><b>Ime: </b>"; echo $uporabnik['ime']; echo "</p>
                                    <p><b>Priimek: </b>"; echo $uporabnik['priimek']; echo "</p>
                                    <p><b>Ulica in poštna številka: </b>"; echo $uporabnik['ulica']; echo "</p>
                                    <p><b>Kraj: </b>"; echo $uporabnik['kraj']; echo "</p>
                                    <p><b>Pošta: </b>"; echo $uporabnik['posta']; echo "</p>
                                    <p><b>Država: </b>"; echo $uporabnik['drzava']; echo "</p>
                                    <a href=\""; echo $_SERVER['HTTP_REFERER']; echo "\" class=\"btnP\">
                                        <div class=\"addCustomer\">
                                            <b>Nazaj</b>
                                        </div>
                                    </a>
                                </div>
                                <div class=\"col-md-7 desc-padd\">
                                    <h3>Podatki o naročilu</h3>
                                    <p><b>Datum: </b>"; echo $narocilo['datspr']; echo "</p>";
                                    $skupna = 0;
                                    foreach ($narArt as $key => $naAr) :
                                        $kolicina = $naAr['kolicina'];
                                        $idArtikla = $naAr['idartikla'];
                                        $artikel = GetDataController::getArtikelId($idArtikla);
                                        $slika = GetDataController::getSlika($artikel);

                                        echo "<div class='card mb-6 shadow-sm'>
                                                <div>
                                                    <img class=\"card-img-top\"
                                                    src=\""; echo $slika[0]['link']; echo "\"
                                                    alt=\"Alt for picture\">
                                                </div>
                                                <div class='card-body'>
                                                    <p class='card'>"; echo $artikel['naziv'];  echo ", kolicina: "; echo $kolicina; echo ", cena: "; echo $kolicina * $artikel['cena']; $skupna += $kolicina * $artikel['cena']; echo " €"; echo"</p>
                                                </div>
                                            </div></br>";
                                    endforeach;
                                    echo "<h2>Skupna cena: "; echo $skupna; echo " €"; echo "</h2>";
                                echo "</div>
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
