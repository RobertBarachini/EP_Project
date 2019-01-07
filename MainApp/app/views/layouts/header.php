<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TopShop</title>
    <link href="/statics/css/bootstrap.min.css" rel="stylesheet">
    <link href="/statics/css/style.css" rel="stylesheet">
    <link href="/statics/js/bootstrap.min.js" rel="stylesheet">
    <link href="/statics/js/jquery-3.3.1.min.js" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/all.css">
    <script src="/statics/ajaxJs/ratingupdate.js"></script>
    <script src="/statics/ajaxJs/kosaricaUpdate.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="<?= ROOT_URL ?>">
        <img src="/statics/logo.png" class="img-icon-top" height="50px">
        TOP SHOP
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">

            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-light my-2 my-sm-0" type="submit">Search</button>
            </form>
        </ul>

        <div>
            <button id="myButton" class=" btn btn-large btn-warning" href="/uporabniki/ajDi/kosarica">
                <i class=" fa fa-shopping-cart"></i>
            </button>

            <script type="text/javascript">
                document.getElementById("myButton").onclick = function () {
                    location.href = "/uporabniki/22323/kosarica";
                };
            </script>

            <?php
                if(!isset($_COOKIE['cookie'])) {
                    echo "<a class='navbar-brand' style=\"margin-left: 25px\" , href='/login'>Prijava</a>";
                    echo "<a class='navbar-brand' , href='/register'>Registracija</a>";
                } else {
                    $uporabnik = requestUtil::sendRequest('http://localhost/trgovina/api/v1/uporabniki/read_one_piskotek.php'  . '?piskotek=' . $_COOKIE['cookie'], "GET", "");
                    $berljiviPodatki = json_encode($uporabnik);
                    $decodiraniPodatki = json_decode($berljiviPodatki,true);

                    echo "<div class=\"dropdown\">
                            <button class=\"dropbtn\">";
                    echo $decodiraniPodatki['ime'];
                    echo"</button>
                            <div class=\"dropdown-content\">
                                <a href=\"/profil\">Profil</a>
                                <a href=\"/logout\">Odjava</a>
                            </div>
                        </div>";
                }
            ?>
        </div>
    </div>
</nav>