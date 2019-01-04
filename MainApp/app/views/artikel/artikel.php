<?php include_once('app/views/layouts/header.php'); ?>
    <!-- Column 1 slika in naslov -->

    <div class="album py-5 bg-light">
        <div class="artikelPage-padd">
            <h1><?= $artikel['naziv'] ?></h1>
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-6 shadow-sm">
                        <img class="card-img-top"
                             src="http://www.jordan2u.com/image/cache/catalog/products/nike-kobe-9-12127-c-1080x1080.jpg"
                             alt="Alt for picture">
                    </div>
                    <div class="card-body">
                        <p class="card-"> <?= $artikel['opis'] ?> </p>
                    </div>
                </div>
                <div class="col-md-6 desc-padd">
                    <p><span>Cena:</span> <?= $artikel['cena'] ?> €</p>
                    <p><span>Povprečna ocena:</span> <?= $artikel['povprecna_ocena'] ?></p>
                    <p><span>Stevilo ocen:</span> <?= $artikel['st_ocen'] ?></p>
                    <p><span>Ocenite izdelek!</span>
                        <br>
                    <div class="stars">
                        <form action="">
                            <input class="star star-5" id="star-5" type="radio" name="star"/>
                            <label class="star star-5" for="star-5"></label>
                            <input class="star star-4" id="star-4" type="radio" name="star"/>
                            <label class="star star-4" for="star-4"></label>
                            <input class="star star-3" id="star-3" type="radio" name="star"/>
                            <label class="star star-3" for="star-3"></label>
                            <input class="star star-2" id="star-2" type="radio" name="star"/>
                            <label class="star star-2" for="star-2"></label>
                            <input class="star star-1" id="star-1" type="radio" name="star"/>
                            <label class="star star-1" for="star-1"></label>
                        </form>
                    </div>
                    <br><br>
                    <div>
                        <button class=" btn btn-large btn-danger" onclick="">
                            <i class="fa fa-shopping-cart"></i> Dodaj v košarico
                        </button>
                    </div>
                    </p>
                </div>
            </div>
        </div>
    </div>

<?php include_once('app/views/layouts/footer.php'); ?>