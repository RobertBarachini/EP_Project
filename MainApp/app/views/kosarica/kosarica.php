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

                            <div class="img-wrap"><img src="<?= $slike[$key]['link'] ?>"
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
                        <select name="selectCena" onchange="updatePrice()" class="form-control">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </td>
                    <td>
                        <div class="price-wrap">
                            <var name="cenaSkupna" class="price"><?= $art['cena'] ?> EUR</var>
                            <small name="cena" class="text-muted">(<?= $art['cena'] ?> EUR each)</small>
                        </div> <!-- price-wrap .// -->
                    </td>
                    <td class="text-right">
                        <button onclick="removeKebab(<?= $art["idartikla"] ?>,<?= $podatkiZaNarocilo[$key]["idnarocila_artikli"] ?> )" class="btn btn-outline-danger"> ×
                            Remove
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div> <!-- card.// -->
    <div class="pull-right">
        <a href="/uporabniki/1/checkout/1" class="btn btn-outline-success " style="margin-top: 2%"> Checkout</a>
    </div>

</div>


<?php include_once('app/views/layouts/footer.php'); ?>
