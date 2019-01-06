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
                          <span class="price">3 x <?= $art['cena'] ?>€</span>
                          <p class="item-name"><?= $art['naziv'] ?></p>
                          <p class="item-description"><?= $art['opis'] ?></p>
                      </div>
                  <?php endforeach; ?>
                    <div class="total">Skupno <span class="price">69€</span></div>
                </div>
                <div class="form-group col-sm-12">
                    <button type="button" class="btn btn-primary btn-block">Checkout</button>
                </div>
            </form>
        </div>
    </section>
</main>


<?php include_once('app/views/layouts/footer.php'); ?>
