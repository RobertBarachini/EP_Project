<?php include_once('app/views/layouts/header.php'); ?>
<div class="container">
    <div class="card">
        <table class="table table-hover shopping-cart-wrap">
            <thead class="text-muted">
            <tr>
                <th scope="col">Artikel</th>
                <th scope="col" width="120">Količina</th>
                <th scope="col" width="120">Cena</th>
                <th scope="col" width="200" class="text-right">Akcija</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($artikli as $key => $art): ?>
                <tr id="<?= $art["idartikla"] ?>">
                    <td>
                        <figure class="media">

                            <div class="img-wrap"><img src= "../../images/<?= $slike[$key]['link'] ?>"
                                                       class="img-thumbnail img-sm"></div>
                            <figcaption class="media-body">
                                <h6 class="title text-truncate"><?= $art['naziv'] ?> </h6>
                                <dl class="param param-inline small">
                                    <dt>Opis:</dt>
                                    <dd><?= $art['opis'] ?></dd>
                                </dl>
                            </figcaption>
                        </figure>
                    </td>
                    <td>

                        <select id="<?= $art["naziv"] ?>"
                                onchange="updatePrice('<?= $art['naziv'] ?>', <?= $podatkiZaNarocilo[$key]["idnarocila_artikli"] ?>, <?= $podatkiZaNarocilo[$key]["idnarocila"] ?>,<?= $podatkiZaNarocilo[$key]["idartikla"] ?>)"
                                class="form-control">
                          <?php
                          if ($podatkiZaNarocilo[$key]["kolicina"] == 1) {
                            echo "
                                        <option selected>1</option>
                                    ";
                          } else echo " 
                                    <option>1</option>
                                ";

                          if ($podatkiZaNarocilo[$key]["kolicina"] == 2) {
                            echo "
                                            <option selected>2</option>
                                        ";
                          } else echo " 
                                        <option>2</option>
                                    ";

                          if ($podatkiZaNarocilo[$key]["kolicina"] == 3) {
                            echo "
                                <option selected>3</option>
                                ";
                          } else echo "
                                <option>3</option>
                                ";
                          if ($podatkiZaNarocilo[$key]["kolicina"] == 4) {
                            echo "
                                <option selected>4</option>
                                ";
                          } else echo "
                                <option>4</option>
                                ";

                          ?>

                        </select>
                    </td>
                    <td>
                        <div class="price-wrap">
                            <var id="cenaSkupna/<?= $art["naziv"] ?>" class="price"><?= $art['cena']*$podatkiZaNarocilo[$key]["kolicina"]?> EUR</var>
                            <small id="cena/<?= $art["naziv"] ?>" class="text-muted">(<?= $art['cena'] ?> EUR each)
                            </small>
                        </div> <!-- price-wrap .// -->
                    </td>
                    <td class="text-right">
                        <button onclick="removeKebab(<?= $art["idartikla"] ?>,<?= $podatkiZaNarocilo[$key]["idnarocila_artikli"] ?> )"
                                class="btn btn-outline-danger"> ×
                            Remove
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div> <!-- card.// -->
    <div class="pull-right">
        <a href="/uporabniki/<?= $uporab ?>/checkout/<?= $idNarocila ?>" class="btn btn-outline-success "
           style="margin-top: 2%"> Checkout</a>
    </div>

</div>


<?php include_once('app/views/layouts/footer.php'); ?>
