<?php

require_once "ViewHelper.php";
require_once "requestUtil.php";
require_once "app/controllers/GetDataController.php";

class ProdajalecController {

    public static function prodajalec() {
    echo ViewHelper::render("app/views/prodajalec/uploadPicture.php", []);
    }

    public static function showProdajalecConsole() {
      $uporabniki = requestUtil::sendRequest("http://localhost/trgovina/api/v1/uporabniki/read.php","GET","");
      $berljiviPodatki = json_encode($uporabniki);
      $decodiraniPodatki = json_decode($berljiviPodatki,true);
      $podatkiUsr = $decodiraniPodatki['body'];

      $artikli = requestUtil::sendRequest("http://localhost/trgovina/api/v1/artikli/read.php","GET","");
      $berljiviPodatki = json_encode($artikli);
      $decodiraniPodatki = json_decode($berljiviPodatki,true);
      $podatkiArt = $decodiraniPodatki['body'];

      echo ViewHelper::render("app/views/prodajalec/prodajalec.php", ["stranke"=>$podatkiUsr, "artikli"=>$podatkiArt]);
    }

    public static function showAddCustomer() {
        echo ViewHelper::render("app/views/prodajalec/addCustomer.php", []);
    }

    public static function showAddArtikel() {
        echo ViewHelper::render("app/views/prodajalec/addArtikel.php", []);
    }

    public static function showCustomerDetails($method, $id) {
        $uporabnikT = requestUtil::sendRequest('http://localhost/api/v1/uporabniki/read_one.php' . '?id=' . $id, "GET", "");
        $berljiviPodatki = json_encode($uporabnikT);
        $uporabnik = json_decode($berljiviPodatki, true);

        echo ViewHelper::render("app/views/prodajalec/customerDetails.php", ["usr"=>$uporabnik]);
    }

    public static function showEditCustomerDetails($method, $id) {
        $uporabnikT = requestUtil::sendRequest('http://localhost/api/v1/uporabniki/read_one.php' . '?id=' . $id, "GET", "");
        $berljiviPodatki = json_encode($uporabnikT);
        $uporabnik = json_decode($berljiviPodatki, true);

        echo ViewHelper::render("app/views/prodajalec/editCustomer.php", ["user"=>$uporabnik]);
    }

    public static function editCustomerDetails($POST, $id) {
        $uporabnikT = requestUtil::sendRequest('http://localhost/api/v1/uporabniki/read_one.php' . '?id=' . $id, "GET", "");
        $berljiviPodatki = json_encode($uporabnikT);
        $uporabnik = json_decode($berljiviPodatki, true);

        # Users' new data
        $ime = $POST['ime'];
        $priimek = $POST['priimek'];
        $ulica = $POST['ulica'];
        $kraj = $POST['kraj'];
        $posta = $POST['posta'];
        $drzava = $POST['drzava'];
        $email = $POST['email'];
        $id = $uporabnik['iduporabnika'];
        $idvloge = $uporabnik['idvloge'];
        $idcert = $uporabnik['idcert'];
        $indmailpotrjen = $uporabnik['indmailpotrjen'] == null ? "0" : $uporabnik['indmailpotrjen'];
        $geslo = $uporabnik['geslo'];
        $sol = $uporabnik['sol'];
        $piskotek = $uporabnik['piskotek'];
        $datprijave = date("Y-m-d H:i:s");
        $idspr = $uporabnik['idspr'] == null ? "1" : $uporabnik['idspr'];
        $datspr = date("Y-m-d H:i:s");
        $status = $uporabnik['status'];

        # For body of request
        $uporabnik_arr = array(
            "iduporabnika" => $id,
            "idvloge" => "$idvloge",
            "idcert" => "$idcert",
            "email" => "$email",
            "indmailpotrjen" => "$indmailpotrjen",
            "geslo" => "$geslo",
            "sol" => "$sol",
            "piskotek" => "$piskotek",
            "ime" => "$ime",
            "priimek" => "$priimek",
            "ulica" => "$ulica",
            "posta" => "$posta",
            "kraj" => "$kraj",
            "drzava" => "$drzava",
            "datprijave" => "$datprijave",
            "idspr" => "$idspr",
            "datspr" => "$datspr",
            "status" => "$status",
        );

        # Update user
        requestUtil::sendRequestPUT('http://localhost/trgovina/api/v1/uporabniki/update.php', "PUT", $uporabnik_arr);
        ViewHelper::redirect(ROOT_URL . 'prodajalec' . DS . 'customer' . DS . $id);
    }

    public static function addCustomer($post) {
        error_reporting(E_ALL & ~E_DEPRECATED);

        $ime = $post['ime'];
        $priimek = $post['priimek'];
        $ulica = $post['ulica'];
        $kraj = $post['kraj'];
        $posta = $post['posta'];
        $drzava = $post['drzava'];
        $email = $post['email'];
        $geslo = $post['geslo'];

        # Check if there are empty fields
        if(empty($ime) || empty($priimek) || empty($ulica)
            || empty($kraj) || empty($posta) || empty($drzava) || empty($geslo) || empty($email)) {
            echo "<div class=\"alert alert-danger errorImg\">
                                        <strong>Napaka!</strong> Izpolnite vsa polja!
                                    </div>";
        } else {
            # Check if first and lastname are in correct form
            if(!preg_match("/^[a-zA-Z]*$/", $ime) || !preg_match("/^[a-zA-Z]*$/", $priimek)) {
                echo "<div class=\"alert alert-danger errorImg\">
                                        <strong>Napaka!</strong> Ime in priimek lahko vsebujeta samo črke!
                                    </div>";
            } else {
                #Check if email is valid
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    echo "<div class=\"alert alert-danger errorImg\">
                                        <strong>Napaka!</strong> Elektronski naslov mora biti pravilne oblike (_@_._) 
                                    </div>";
                } else {
                    $salt = RegisterController::generateRandomString();
                    $hpwd = password_hash($geslo, PASSWORD_DEFAULT, ['salt' => $salt]);
                    $hashedPassword = password_hash($hpwd . $salt, PASSWORD_DEFAULT, ['salt' => $salt]);

                    $uporabnik_arr = array(
                        "idvloge" => "S",
                        "idcert" => null,
                        "email" => "$email",
                        "indmailpotrjen" => 0,
                        "geslo" => "$hashedPassword",
                        "sol" => "$salt",
                        "piskotek" => null,
                        "ime" => "$ime",
                        "priimek" => "$priimek",
                        "ulica" => "$ulica",
                        "posta" => "$posta",
                        "kraj" => "$kraj",
                        "drzava" => "$drzava",
                        "idspr" => 0,
                        "status" => 0
                    );
                    $temp = requestUtil::sendRequestPOST("http://localhost/trgovina/api/v1/uporabniki/create.php","POST",$uporabnik_arr);

                    if($temp != "{\"id\":-1,\"message\":\"Unable to create object.\"}") {
                        echo "<div class=\"alert alert-success errorImg\">
                                        <strong>Stranka uspešno kreirana!</strong> 
                                        Nazaj na <a href='"; echo ROOT_URL . 'prodajalec'; echo "'>konzolo prodajalca</a> 
                                    </div>";
                    } else {
                        echo "<div class=\"alert alert-danger errorImg\">
                                        <strong>Napaka!</strong>
                                    </div>";
                    }
                }
            }
        }
    }

    public static function addArtikel($POST) {
        $naziv = $POST['naziv'];
        $opis = $POST['opis'];
        $cena = $POST['cena'];

        $artikel_arr = array(
            "naziv" => $naziv,
            "opis" => $opis,
            "cena" => $cena,
            "idspr" => "0"
        );

        $temp = requestUtil::sendRequestPOST("http://localhost/trgovina/api/v1/artikli/create.php","POST",$artikel_arr);

        if($temp == "{\"id\":-1,\"message\":\"Unable to create object.\"}") {
            echo "<div class=\"alert alert-danger error\">
                                        <strong>Napaka!</strong> Artikla ni bilo mogoče dodati!</br>
                                        Polje naziv in cena sta obvezna! Polje cena mora biti numerična vrednost!
                                    </div>";
        } else {
            echo "<div class=\"alert alert-success errorImg\">
                                        <strong>Artikel uspešno kreirana!</strong> 
                                        Nazaj na <a href='"; echo ROOT_URL . 'prodajalec'; echo "'>konzolo prodajalca</a> 
                                    </div>";
        }
    }

    public static function showArtikelDetails($method, $id) {
        $artikelT = requestUtil::sendRequest('http://localhost/api/v1/artikli/read_one.php' . '?id=' . $id, "GET", "");
        $berljiviPodatki = json_encode($artikelT);
        $artikel = json_decode($berljiviPodatki, true);

        $artikli_slikeT = requestUtil::sendRequest('http://localhost/api/v1/artikli_slike/read.php', "GET", "");
        $berljiviPodatki_slike = json_encode($artikli_slikeT);
        $decodiraniPodatki_slike = json_decode($berljiviPodatki_slike, true);
        $podatki = $decodiraniPodatki_slike['body'];


        echo ViewHelper::render("app/views/prodajalec/artikelDetails.php", ["art"=>$artikel, "slike"=>$podatki]);
    }

    public static function showEditArtikelDetails($method, $id) {
        $artikelT = requestUtil::sendRequest('http://localhost/api/v1/artikli/read_one.php' . '?id=' . $id, "GET", "");
        $berljiviPodatki = json_encode($artikelT);
        $artikel = json_decode($berljiviPodatki, true);

        echo ViewHelper::render("app/views/prodajalec/editArtikel.php", ["arti"=>$artikel]);
    }

    public static function editArtikelDetails($POST, $id) {
        $artikelT = requestUtil::sendRequest('http://localhost/api/v1/artikli/read_one.php' . '?id=' . $id, "GET", "");
        $berljiviPodatki = json_encode($artikelT);
        $artikel = json_decode($berljiviPodatki, true);


        $id = $artikel['idartikla'];
        $naziv = $POST['naziv'];
        $opis = $POST['opis'];
        $cena = $POST['cena'];
        $st_ocen = $artikel['st_ocen'];
        $povprecna_ocena = $artikel['povprecna_ocena'];
        $status = $artikel['status'];
        $datspr = date("Y-m-d H:i:s");
        $idspr = $artikel['idspr'] == null ? "0" : $artikel['idspr'];


        $artikel_arr = array(
            "idartikla"=>"$id",
            "naziv"=> "$naziv",
            "opis"=> "$opis",
            "cena"=> "$cena",
            "st_ocen"=> "$st_ocen",
            "povprecna_ocena"=> "$povprecna_ocena",
            "status"=> "$status",
            "datspr"=> "$datspr",
            "idspr"=> "$idspr"
        );

        requestUtil::sendRequestPUT('http://localhost/trgovina/api/v1/artikli/update.php', "PUT", $artikel_arr);
        ViewHelper::redirect(ROOT_URL . 'prodajalec' . DS . 'artikel' . DS . $id);
    }

    public static function showImageAdd($method, $id) {
        $artikelT = requestUtil::sendRequest('http://localhost/api/v1/artikli/read_one.php' . '?id=' . $id, "GET", "");
        $berljiviPodatki = json_encode($artikelT);
        $artikel = json_decode($berljiviPodatki, true);

        echo ViewHelper::render("app/views/prodajalec/addImage.php", ["artik"=>$artikel]);
    }

    public static function addImage($POST, $FILES) {
        $image = $FILES['image']['name'];
        $image_naziv = $_POST['ime'];
        $image_idartikla = $POST['id'];
        $target = "images/".basename($image);


        $image_link = '../../images/'. $image;
        var_dump($image_link);
        var_dump($image_link);
        var_dump($image_link);
        if($image == null) {
            echo "<div class=\"alert alert-danger errorImg\">
                                        <strong>Napaka!</strong> Naložite sliko!</br>
                                    </div>";
        } else {
            $slika_arr = array(
                "idartikla" => "$image_idartikla",
                "naziv"=> "$image_naziv",
                "link"=>"$image_link",
                "status"=>"0",
                "idspr"=>"1"
            );

            requestUtil::sendRequestPOST('http://localhost/trgovina/api/v1/artikli_slike/create.php', "PUT", $slika_arr);
            if (move_uploaded_file($FILES['image']['tmp_name'], $target)) {
                $msg = "Image uploaded successfully";
            }else{
                $msg = "Failed to upload image";
            }
            ViewHelper::redirect(ROOT_URL . 'prodajalec' . DS . 'artikel' . DS . $image_idartikla);
        }
    }

    public static function deactivate($method, $id) {

        if(isset($_COOKIE['cookie'])) {
            $uporabnikP = GetDataController::getUser();
        }

        $uporabnikTmp = requestUtil::sendRequest('http://localhost/api/v1/uporabniki/read_one.php' . '?id=' . $id, "GET", "");
        $berljiviPodatki = json_encode($uporabnikTmp);
        $uporabnik = json_decode($berljiviPodatki, true);

        if($uporabnikP['idvloge'] == 'P') {

            $ime = $uporabnik['ime'];
            $priimek = $uporabnik['priimek'];
            $ulica = $uporabnik['ulica'];
            $kraj = $uporabnik['kraj'];
            $posta = $uporabnik['posta'];
            $drzava = $uporabnik['drzava'];
            $email = $uporabnik['email'];
            $id = $uporabnik['iduporabnika'];
            $idvloge = $uporabnik['idvloge'];
            $idcert = $uporabnik['idcert'];
            $indmailpotrjen = $uporabnik['indmailpotrjen'] == null ? "0" : $uporabnik['indmailpotrjen'];
            $geslo = $uporabnik['geslo'];
            $sol = $uporabnik['sol'];
            $piskotek = $uporabnik['piskotek'];
            $datprijave = date("Y-m-d H:i:s");
            $idspr = $uporabnik['idspr'] == null ? "1" : $uporabnik['idspr'];
            $datspr = date("Y-m-d H:i:s");
            $status = "5";

            $uporabnik_arr = array(
                "iduporabnika" => $id,
                "idvloge" => "$idvloge",
                "idcert" => "$idcert",
                "email" => "$email",
                "indmailpotrjen" => "$indmailpotrjen",
                "geslo" => "$geslo",
                "sol" => "$sol",
                "piskotek" => "$piskotek",
                "ime" => "$ime",
                "priimek" => "$priimek",
                "ulica" => "$ulica",
                "posta" => "$posta",
                "kraj" => "$kraj",
                "drzava" => "$drzava",
                "datprijave" => "$datprijave",
                "idspr" => "$idspr",
                "datspr" => "$datspr",
                "status" => "$status",
            );

            requestUtil::sendRequestPUT('http://localhost/trgovina/api/v1/uporabniki/update.php', "PUT", $uporabnik_arr);
            ViewHelper::redirect('/prodajalec');
        } else {
            echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
        }
    }

    public static function activate($method, $id) {
        $uporabnikTmp = requestUtil::sendRequest('http://localhost/api/v1/uporabniki/read_one.php' . '?id=' . $id, "GET", "");
        $berljiviPodatki = json_encode($uporabnikTmp);
        $uporabnik = json_decode($berljiviPodatki, true);

        if(isset($_COOKIE['cookie'])) {
            $uporabnikP = GetDataController::getUser();
        }

        if($uporabnikP['idvloge'] == 'P') {

            $ime = $uporabnik['ime'];
            $priimek = $uporabnik['priimek'];
            $ulica = $uporabnik['ulica'];
            $kraj = $uporabnik['kraj'];
            $posta = $uporabnik['posta'];
            $drzava = $uporabnik['drzava'];
            $email = $uporabnik['email'];
            $id = $uporabnik['iduporabnika'];
            $idvloge = $uporabnik['idvloge'];
            $idcert = $uporabnik['idcert'];
            $indmailpotrjen = $uporabnik['indmailpotrjen'] == null ? "0" : $uporabnik['indmailpotrjen'];
            $geslo = $uporabnik['geslo'];
            $sol = $uporabnik['sol'];
            $piskotek = $uporabnik['piskotek'];
            $datprijave = date("Y-m-d H:i:s");
            $idspr = $uporabnik['idspr'] == null ? "1" : $uporabnik['idspr'];
            $datspr = date("Y-m-d H:i:s");
            $status = "0";

            $uporabnik_arr = array(
                "iduporabnika" => $id,
                "idvloge" => "$idvloge",
                "idcert" => "$idcert",
                "email" => "$email",
                "indmailpotrjen" => "$indmailpotrjen",
                "geslo" => "$geslo",
                "sol" => "$sol",
                "piskotek" => "$piskotek",
                "ime" => "$ime",
                "priimek" => "$priimek",
                "ulica" => "$ulica",
                "posta" => "$posta",
                "kraj" => "$kraj",
                "drzava" => "$drzava",
                "datprijave" => "$datprijave",
                "idspr" => "$idspr",
                "datspr" => "$datspr",
                "status" => "$status",
            );
            requestUtil::sendRequestPUT('http://localhost/trgovina/api/v1/uporabniki/update.php', "PUT", $uporabnik_arr);
            ViewHelper::redirect('/prodajalec');
        } else {
            echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
        }
    }

    public static function deactivateArtikel($method, $id) {

        if(isset($_COOKIE['cookie'])) {
            $uporabnik = GetDataController::getUser();

            if($uporabnik['idvloge'] == 'P') {
                $artikel = requestUtil::sendRequest('http://localhost/api/v1/artikli/read_one.php' . '?id=' . $id, "GET", "");
                $berljiviPodatki = json_encode($artikel);
                $decodiraniPodatki = json_decode($berljiviPodatki, true);

                $id = $decodiraniPodatki['idartikla'];
                $naziv = $decodiraniPodatki['naziv'];
                $opis = $decodiraniPodatki['opis'];
                $cena = $decodiraniPodatki['cena'];
                $st_ocen = $decodiraniPodatki['st_ocen'] == null ? "0" : $decodiraniPodatki['st_ocen'];
                $povprecna_ocena = $decodiraniPodatki['povprecna_ocena'] == null ? "1" : $decodiraniPodatki['povprecna_ocena'];
                $status = '5';
                $datspr = date("Y-m-d H:i:s");
                $idspr = $decodiraniPodatki['idspr'] == null ? "0" : $decodiraniPodatki['idspr'];

                $artikel_arr = array(
                    "idartikla" => $id,
                    "naziv" => $naziv,
                    "opis" => $opis,
                    "cena" => $cena,
                    "st_ocen" => $st_ocen,
                    "povprecna_ocena" => $povprecna_ocena,
                    "idspr" => "$idspr",
                    "datspr" => "$datspr",
                    "status" => "$status",
                );

                requestUtil::sendRequestPUT('http://localhost/trgovina/api/v1/artikli/update.php', "PUT", $artikel_arr);
                ViewHelper::redirect('/prodajalec');
            } else {
                echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
            }
        } else {
            echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
        }
    }

    public static function activateArtikel($method, $id) {

        if(isset($_COOKIE['cookie'])) {
            $uporabnik = GetDataController::getUser();

            if($uporabnik['idvloge'] == 'P') {
                $artikel = requestUtil::sendRequest('http://localhost/api/v1/artikli/read_one.php' . '?id=' . $id, "GET", "");
                $berljiviPodatki = json_encode($artikel);
                $decodiraniPodatki = json_decode($berljiviPodatki, true);

                $id = $decodiraniPodatki['idartikla'];
                $naziv = $decodiraniPodatki['naziv'];
                $opis = $decodiraniPodatki['opis'];
                $cena = $decodiraniPodatki['cena'];
                $st_ocen = $decodiraniPodatki['st_ocen'] == null ? "0" : $decodiraniPodatki['st_ocen'];
                $povprecna_ocena = $decodiraniPodatki['povprecna_ocena'] == null ? "1" : $decodiraniPodatki['povprecna_ocena'];
                $status = '0';
                $datspr = date("Y-m-d H:i:s");
                $idspr = $decodiraniPodatki['idspr'] == null ? "0" : $decodiraniPodatki['idspr'];

                $artikel_arr = array(
                    "idartikla" => $id,
                    "naziv" => $naziv,
                    "opis" => $opis,
                    "cena" => $cena,
                    "st_ocen" => $st_ocen,
                    "povprecna_ocena" => $povprecna_ocena,
                    "idspr" => "$idspr",
                    "datspr" => "$datspr",
                    "status" => "$status",
                );

                requestUtil::sendRequestPUT('http://localhost/trgovina/api/v1/artikli/update.php', "PUT", $artikel_arr);
                ViewHelper::redirect('/prodajalec');
            } else {
                echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
            }
        } else {
            echo "<h3 style='margin-left: 20px' >Za dostop do konzole prodajalca, je potrebna <a href='/login'>prijava</a> z računom prodajalca!</h3>";
        }
    }

}