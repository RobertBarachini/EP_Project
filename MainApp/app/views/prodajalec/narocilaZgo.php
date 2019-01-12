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
        foreach ($naroc as $key => $narocilo):
            if($narocilo['faza'] != 'N') {
                echo "<a href=\""; echo ROOT_URL . 'prodajalec'. DS . 'narocila'. DS . $narocilo['idnarocila']; echo "\" class=\"btnP\">
                                        <div class=\"prodajalecCard\">
                                            <p>"; echo "Narocilo "; echo $narocilo['idnarocila']; echo " ("; echo $narocilo['datzac_kosarice']; echo ")";

                if($narocilo['faza'] == 'P') {
                    echo " <span style='color: green'>Potrjeno</span>";
                    echo "<a href=\""; echo ROOT_URL . 'narocila' . DS . $narocilo['idnarocila']. DS . 'storniraj'; echo "\" class='storn'>
                                            <i class='fa fa-undo trash'></i>
                                       </a >
                                    </p>    
                                    </div>
                                </a>";
                } else if($narocilo['faza'] == 'S') {
                    echo " <span style='color: orange'>Stornirano</span>";
                    echo "
                                    </p>    
                                    </div>
                                </a>";
                } else if($narocilo['faza'] == 'Z') {
                    echo " <span style='color: red'>Zavrnjeno</span>";
                    echo "
                                    </p>    
                                    </div>
                                </a>";
                }
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
