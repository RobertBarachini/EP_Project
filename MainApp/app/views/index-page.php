<?php include_once('layouts/header.php'); ?>

<main role="main">
  <?php if ($prazno)
    echo "
  <div style='position: fixed;
    top: 50%;
    left: 13%;
    margin-top: -100px;
    margin-left:auto  '> 
    <h1><span class=\"badge badge-primary\">Poizvedba ne ustreza nobenemu izdelku! Minimalno stevilo črk za iskanje je 3!</span></h1>
  </div>
  ";
  ?>
    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row">
              <?php foreach ($artikli as $key => $art): ?>
                <?php foreach ($artikli_slike as $key_s => $art_s): ?>
                  <?php if ($art['status'] == '0') { ?>
                    <?php if ($art['idartikla'] == $art_s['idartikla']) { ?>
                              <div class="col-md-4">
                                  <div class="card mb-4 shadow-sm">
                                      <a href="<?= ROOT_URL . 'artikli' . DS . $art['idartikla'] ?>">
                                          <img class="card-img-top"
                                               src="images/<?= $art_s['link'] ?>"
                                               alt="Card image cap">
                                          <div class="card-body">
                                              <a href="<?= ROOT_URL . 'artikli' . DS . $art['idartikla'] ?>"
                                                 class="card-user">
                                                  <h5> <?= $art['naziv'] ?> </h5></a>
                                              <p class="card-text"> <?= $art['opis'] ?> </p>
                                              <p class="card-text"> <?= $art['cena'] ?> €</p>
                                          </div>
                                      </a>
                                  </div>
                              </div>
                      <?php break;
                    } ?>
                  <?php } else {
                    break;
                  } ?>
                  <?php if ($art_s == end($artikli_slike)) { ?>
                          <div class="col-md-4">
                              <div class="card mb-4 shadow-sm">
                                  <a href="<?= ROOT_URL . 'artikli' . DS . $art['idartikla'] ?>">
                                      <img class="card-img-top"
                                           src="images_init/no_image.jpg"
                                           alt="Card image cap">
                                      <div class="card-body">
                                          <a href="<?= ROOT_URL . 'artikli' . DS . $art['idartikla'] ?>"
                                             class="card-user">
                                              <h5> <?= $art['naziv'] ?> </h5></a>
                                          <p class="card-text"> <?= $art['opis'] ?> </p>
                                          <p class="card-text"> <?= $art['cena'] ?> €</p>
                                      </div>
                                  </a>
                              </div>
                          </div>
                  <?php } ?>
                <?php endforeach; ?>
              <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>

<?php include_once('layouts/footer.php'); ?>
