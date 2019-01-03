<?php include_once('layouts/header.php'); ?>

<main role="main">
    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row">
          <?php foreach ($artikli as $key => $art): ?>
              <div class="col-md-4">
                  <div class="card mb-4 shadow-sm">
                      <a href="">
                          <img class="card-img-top"
                               src="http://www.jordan2u.com/image/cache/catalog/products/nike-kobe-9-12127-c-1080x1080.jpg"
                               alt="Card image cap">
                          <div class="card-body">
                              <a href="" class="card-user"> <h5> <?= $art['naziv'] ?> </h5> </a href="">
                              <p class="card-text"> <?= $art['opis'] ?> </p>
                          </div>
                      </a>
                  </div>
              </div>
          <?php endforeach; ?>
            </div>
        </div>
    </div>
</main>

<?php include_once('layouts/footer.php'); ?>
