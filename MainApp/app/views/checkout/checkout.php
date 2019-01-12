<?php include_once('app/views/layouts/header.php'); ?>

<main class="page payment-page">
    <section class="payment-form dark">
        <div class="container">
            <div class="block-heading">
                <h2>Plačilo</h2>
                <p>Na črnem trgu ni davka, hvala za razumevanje.</p>
            </div>
            <form>
                <div class="products">
                    <h3 class="title">Checkout</h3>
                  <?php foreach ($artikli as $key => $art): ?>
                      <div class="item">
                          <span class="price"><?=$podatkiZaNarocilo[$key]['kolicina'] ?> x <?= $art['cena'] ?>€</span>
                          <p class="item-name"><?= $art['naziv'] ?></p>
                          <p class="item-description"><?= $art['opis'] ?></p>
                      </div>
                  <?php endforeach; ?>
                    <div class="total">Skupno <span class="price"><?= $cenaS ?> €</span></div>
                </div>

                <div class="form-group col-sm-12">
                    <a id="myBtn" onclick="checkout(<?= $podatkiZaNarocilo[0]['idnarocila']?>, <?= $uporab ?>)" class="btn btn-primary btn-block" style="color: white;">Checkout</a>
                    <!-- The Modal -->
                    <div id="myModal" class="modal">

                        <!-- Modal content -->
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2>Pozdravljeni!</h2>
                            </div>
                            <div class="modal-body">
                                <p>Hvala za vaš nakup! V kratkem bo naš prodajalec preveril vašo narocilo. Do takrat lahko stanje nakupa preverite na strani vašega profila pod tab NAROČILA</p>
                                <a href="/">Kliknite tukaj za preusmeritev na glavno stran.</a>
                                <?php
                                ?>
                                <br><br>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </section>
</main>


<?php include_once('app/views/layouts/footer.php'); ?>
