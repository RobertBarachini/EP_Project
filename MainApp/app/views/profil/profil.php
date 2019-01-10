<?php include_once('app/views/layouts/header.php'); ?>
<?php
    if(isset($_COOKIE['cookie'])) {
        $uporabnik = requestUtil::sendRequest('http://localhost/trgovina/api/v1/uporabniki/read_one_piskotek.php'  . '?piskotek=' . $_COOKIE['cookie'], "GET", "");

        if($uporabnik == null) {
            # User wants to use fake cookie --> user is not found in database
            echo "<h3 style='margin-left: 20px' >Ne najdem uporabnika s tem piškotkom!</h3>";
        } else {
            $berljiviPodatki = json_encode($uporabnik);
            $decodiraniPodatki = json_decode($berljiviPodatki, true);

            echo "<div class=\"container\">
                <div class=\"album py-5 bg-light\">
                    <div class=\"artikelPage-padd\">
                        <h1>Profil uporabnika</h1>
                        <form action=\"/profil/edit\">
                            <button class=\"editProfil\">Spremeni podatke</button>
                        </form>
                        <form action=\"/profil/edit/password\">
                            <button class=\"editProfil\">Spremeni geslo</button>
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
                                <p><b>Ime:</b>"; echo $decodiraniPodatki['ime']; echo "</p>
                                <p><b>Priimek: </b>"; echo $decodiraniPodatki['priimek']; echo "</p>
                                <p><b>Ulica in hišna številka: </b>"; echo $decodiraniPodatki['ulica']; echo "</p>
                                <p><b>Kraj: </b>"; echo $decodiraniPodatki['kraj']; echo "</p>
                                <p><b>Pošta: </b>"; echo $decodiraniPodatki['posta']; echo "</p>
                                <p><b>Država: </b>"; echo $decodiraniPodatki['drzava']; echo "</p>
                                <p><b>Elektronski naslov: </b>"; echo $decodiraniPodatki['email']; echo "</p>
                            </div>
                        </div>
                    </div>
                </div>
              </div>";
        }
    } else {
        # User is not logged in and wants to access page profil
        echo "<h3 style='margin-left: 20px' >Za dostop do profila uporabnika, je potrebna <a href='/login'>prijava</a>!</h3>";
    }
?>

<?php include_once('app/views/layouts/footer.php'); ?>
