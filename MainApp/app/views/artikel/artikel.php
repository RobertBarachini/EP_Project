<?php include_once('app/views/layouts/header.php'); ?>
    <!-- Column 1 slika in naslov -->

    <script>
        $(document).ready(function () {
            $('.slider').bxSlider();
        });
    </script>

    <div class="album py-5 bg-light">
        <div class="artikelPage-padd">
            <h1><?= $artikel['naziv'] ?></h1>
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-6 shadow-sm ">
                        <div class="slider">
                          <?php foreach ($artikel_slike as $key => $value): ?>
                              <div>
                                  <img class="card-img-top"
                                       src="../../images/<?= $value['link'] ?>"
                                       alt="Alt for picture">
                              </div>
                          <?php endforeach; ?>
                        </div>
                        <div class="card-body">
                            <p class="card-"> <?= $artikel['opis'] ?> </p>
                        </div>
                    </div>

                </div>
                <div class="col-md-6 desc-padd">
                    <h3><span>Cena:</span> <?= $artikel['cena'] ?> €</h3> <br>
                    <h3 id="povpOcena"><span>Povprečna ocena:</span> <?= $artikel['povprecna_ocena'] ?></h3> <br>
                    <h3 id="stOc"><span>Stevilo ocen:</span> <?= $artikel['st_ocen'] ?></h3> <br>

                  <?php

                  if (isset($_COOKIE['cookie']) && !$jeZeDalOceno) {
                  echo "
                        <p><span id=\"tekst\">Ocenite izdelek!</span>
                          <br>
                          <div class=\"stars\">
                              <form action=\"\">
                                  <input class=\"star star-5\" id=\"star-5\" type=\"radio\" name=\"star\" onchange=\"updateRating(5,{$artikel['idartikla']},'{$artikel['naziv']}','{$artikel['opis']}', {$artikel['cena']}, {$artikel['povprecna_ocena']}, {$artikel['st_ocen']}, {$iduporabnika}) \"/>
                                  <label class=\"star star-5\" for=\"star-5\"></label>
                                  <input class=\"star star-4\" id=\"star-4\" type=\"radio\" name=\"star\" onchange=\"updateRating(4,{$artikel['idartikla']},'{$artikel['naziv']}','{$artikel['opis']}', {$artikel['cena']}, {$artikel['povprecna_ocena']}, {$artikel['st_ocen']}, {$iduporabnika})\"/>
                                  <label class=\"star star-4\" for=\"star-4\"></label>
                                  <input class=\"star star-3\" id=\"star-3\" type=\"radio\" name=\"star\" onchange=\"updateRating(3,{$artikel['idartikla']},'{$artikel['naziv']}','{$artikel['opis']}', {$artikel['cena']}, {$artikel['povprecna_ocena']}, {$artikel['st_ocen']}, {$iduporabnika})\"/>
                                  <label class=\"star star-3\" for=\"star-3\"></label>
                                  <input class=\"star star-2\" id=\"star-2\" type=\"radio\" name=\"star\" onchange=\"updateRating(2,{$artikel['idartikla']},'{$artikel['naziv']}','{$artikel['opis']}', {$artikel['cena']}, {$artikel['povprecna_ocena']}, {$artikel['st_ocen']}, {$iduporabnika})\"/>
                                  <label class=\"star star-2\" for=\"star-2\"></label>
                                  <input class=\"star star-1\" id=\"star-1\" type=\"radio\" name=\"star\" onchange=\"updateRating(1,{$artikel['idartikla']},'{$artikel['naziv']}','{$artikel['opis']}', {$artikel['cena']}, {$artikel['povprecna_ocena']}, {$artikel['st_ocen']}, {$iduporabnika})\"/>
                                  <label class=\"star star-1\" for=\"star-1\"></label>
                              </form>
                          </div>
                          <br><br>
                         <div>
                        <button class=\" btn btn-large btn-danger\" onclick=\"\">
                            <i class=\"fa fa-shopping-cart\"></i> Dodaj v košarico
                        </button>
                        </div>    
                        </p>          
                          
                    ";}

                  if (isset($_COOKIE['cookie']) && $jeZeDalOceno && $ocena) {
                    echo "
                        <p><span style=\"color: red\">Izdelek ste že ocenili!</span>
                        <br>
                          <div class=\"stars\">
                              <form action=\"\" >
                              ";
                    if($ocena == 5) {
                        echo "<input class=\"star star-5\" id=\"star-5\" type=\"radio\" name=\"star\" checked disabled = \"true\" \"/>
                                  <label class=\"star star-5\" for=\"star-5\"> </label>";
                    } else {
                        echo "<input class=\"star star-5\" id=\"star-5\" type=\"radio\" name=\"star\" disabled = \"true\" \"/>
                                  <label class=\"star star-5\" for=\"star-5\"> </label>";
                    }

                    if($ocena == 4) {
                      echo "<input class=\"star star-4\" id=\"star-4\" type=\"radio\" name=\"star\" checked disabled = \"true\"  \"/>
                                  <label class=\"star star-4\" for=\"star-4\"> </label>";
                    } else {
                      echo "<input class=\"star star-4\" id=\"star-4\" type=\"radio\" name=\"star\" disabled = \"true\"  \"/>
                                  <label class=\"star star-4\" for=\"star-4\"> </label>";
                    }
                    if($ocena == 3) {
                      echo "<input class=\"star star-3\" id=\"star-3\" type=\"radio\" name=\"star\" disabled = \"true\"  checked \"/>
                                  <label class=\"star star-3\" for=\"star-3\"> </label>";
                    } else {
                      echo "<input class=\"star star-3\" id=\"star-3\" type=\"radio\" name=\"star\" disabled = \"true\"  \"/>
                                  <label class=\"star star-3\" for=\"star-3\"> </label>";
                    }
                    if($ocena == 2) {
                      echo "<input class=\"star star-2\" id=\"star-2\" type=\"radio\" name=\"star\" disabled = \"true\"  checked \"/>
                                  <label class=\"star star-2\" for=\"star-2\"> </label>";
                    } else {
                      echo "<input class=\"star star-2\" id=\"star-2\" type=\"radio\" name=\"star\" disabled = \"true\"  \"/>
                                  <label class=\"star star-2\" for=\"star-2\"> </label>";
                    }
                    if($ocena == 1) {
                      echo "<input class=\"star star-1\" id=\"star-1\" type=\"radio\" name=\"star\" disabled = \"true\"  checked \"/>
                                  <label class=\"star star-1\" for=\"star-1\"> </label>";
                    } else {
                      echo "<input class=\"star star-1\" id=\"star-1\" type=\"radio\" name=\"star\" disabled = \"true\"  \"/>
                                  <label class=\"star star-1\" for=\"star-1\"> </label>";
                    }

                     echo "
                              </form>
                          </div>
                          <br><br>
                         <div>
                        <button class=\" btn btn-large btn-danger\" onclick=\"dodajVKosarico({$iduporabnika})\">
                            <i class=\"fa fa-shopping-cart\"></i> Dodaj v košarico
                        </button>
                        </div>    
                        </p>                              
                        ";
                  }
                  ?>

                </div>
            </div>
        </div>
    </div>

  <?php include_once('app/views/layouts/footer.php'); ?>