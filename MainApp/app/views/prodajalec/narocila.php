<?php include_once('app/views/layouts/header.php'); ?>
<?php require_once "app/controllers/GetDataController.php"; ?>
<?php
if(isset($_COOKIE['cookie'])) {
    $uporabnik = GetDataController::getUser();

    if($uporabnik['idvloge'] == 'P') {
        echo "<div class=\"container\">
                    <div class=\"nav-login\">
                        <div class=\"adminDiv\">
                            <h1 class=\"prodajalecHeader\">Naročila</h1>
                            <div class=\"col-md-12\">";
                    foreach ($narocila as $key => $narocilo):
                        if($narocilo['faza'] == 'N') {
                            echo "<a href=\""; echo ROOT_URL . 'prodajalec'. DS . 'narocila'. DS . $narocilo['idnarocila']; echo "\" class=\"btnP\">
                                        <div class=\"prodajalecCard\">
                                            <p>"; echo "Narocilo "; echo $narocilo['idnarocila']; echo " ("; echo $narocilo['datzac_kosarice']; echo ")";

                            echo "<a href=\""; echo ROOT_URL . 'narocila' . DS . $narocilo['idnarocila']. DS . 'decline'; echo "\" class='delete'>
                                            <i class=\"fa fa-close trash\" ></i>
                                       </a >
                                        <a href=\""; echo ROOT_URL . 'narocila' . DS . $narocilo['idnarocila']. DS . 'accept'; echo "\" class='ok'>
                                            <i class=\"fa fa-check trash\"></i>
                                       </a>
                                    </p>    
                                    </div>
                                </a>";
                        }
                       endforeach;
                    echo "</div>
                        </div>
                    </div>
                    <a href=\"/prodajalec\" class=\"btnP\">
                            <div class=\"addCustomer\">
                                <b>Nazaj na konzolo</b>
                            </div>
                     </a>
                </div>";
    } else {
        echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
    }
} else {
    echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
}
?>
<?php include_once('app/views/layouts/footer.php'); ?>
