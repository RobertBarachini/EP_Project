<?php require_once "app/controllers/GetDataController.php"; ?>
<?php include_once('app/views/layouts/header.php'); ?>
<?php
    if(isset($_COOKIE['cookie'])) {
        $uporabnik = GetDataController::getUser();

        if($uporabnik['idvloge'] == 'A') {
            echo "<div class=\"container\">
                    <div class=\"nav-login\">
                        <div class=\"adminDiv\">
                            <h1 class=\"adminHeader\">Administratorska konzola</h1>
                            <div class=\"col-md-12\">";
                                foreach ($uporabniki as $key => $uporabnik):
                                    if($uporabnik['idvloge'] == 'P') {
                                        echo "<a href=\""; echo ROOT_URL . 'admin' . DS . 'seller' . DS . $uporabnik['iduporabnika']; echo "\" class=\"btnP\">
                                                <div class=\"prodajalecCard\">
                                                    <p>Prodajalec: "; echo $uporabnik['ime']; echo " "; echo $uporabnik['priimek']; echo " - ";
                                                    if($uporabnik['status'] == '0') {
                                                        echo "<a class='deactivate' href=\""; echo ROOT_URL . 'deactivate'. DS . $uporabnik['iduporabnika']; echo"\">Aktiviran</a>";
                                                    } else if($uporabnik['status'] == '5') {
                                                        echo "<a class='activate' href=\""; echo ROOT_URL . 'activate'. DS . $uporabnik['iduporabnika']; echo"\">Deaktiviran</a>";
                                                    } echo "</p>
                                                </div>
                                            </a>
                                      ";}
                                 endforeach;
                            echo "</div>
                            <a href=\"/admin/seller/add\" class=\"btnP\">
                                <div class=\"addSeller\">
                                    <b>Dodaj prodajalca</b>
                                </div>
                            </a>
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
<a href="">
    <div>
        <a>

        </a>
    </div>
</a>l

<?php include_once('app/views/layouts/footer.php'); ?>
