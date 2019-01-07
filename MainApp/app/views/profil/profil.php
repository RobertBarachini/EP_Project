<?php include_once('app/views/layouts/header.php'); ?>
<?php
    if(isset($_COOKIE['cookie'])) {
        $uporabnik = requestUtil::sendRequest('http://localhost/trgovina/api/v1/uporabniki/read_one_piskotek.php'  . '?piskotek=' . $_COOKIE['cookie'], "GET", "");
        $berljiviPodatki = json_encode($uporabnik);
        $decodiraniPodatki = json_decode($berljiviPodatki,true);
    }
?>
<div class="container">
    <div class="album py-5 bg-light">
        <div class="artikelPage-padd">
            <h1>Profil uporabnika</h1>
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-6 shadow-sm">
                        <img class="card-img-top"
                             src="https://avatars2.githubusercontent.com/u/13259803?s=460&v=4"
                             alt="Alt for picture">
                    </div>
                </div>
                <div class="col-md-6 desc-padd">
                    <p><b>Ime:</b> <?php echo $decodiraniPodatki['ime']; ?></p>
                    <p><b>Priimek:</b> <?php echo $decodiraniPodatki['priimek']; ?></p>
                    <p><b>Ulica in hišna številka:</b> <?php echo $decodiraniPodatki['ulica']; ?></p>
                    <p><b>Kraj:</b> <?php echo $decodiraniPodatki['kraj']; ?></p>
                    <p><b>Pošta:</b> <?php echo $decodiraniPodatki['posta']; ?></p>
                    <p><b>Država:</b> <?php echo $decodiraniPodatki['drzava']; ?></p>
                    <p><b>Elektronski naslov:</b> <?php echo $decodiraniPodatki['email']; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once('app/views/layouts/footer.php'); ?>
