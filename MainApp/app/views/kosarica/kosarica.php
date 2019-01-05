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
                <tr>
                    <td>
                        <figure class="media">
                            <div class="img-wrap"><img src="http://bootstrap-ecommerce.com/main/images/items/2.jpg"
                                                       class="img-thumbnail img-sm"></div>
                            <figcaption class="media-body">
                                <h6 class="title text-truncate">Lesena omara </h6>
                                <dl class="param param-inline small">
                                    <dt>Opis:</dt>
                                    <dd>Malo stara ma dwbra!</dd>
                                </dl>
                            </figcaption>
                        </figure>
                    </td>
                    <td>
                        <select class="form-control">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </td>
                    <td>
                        <div class="price-wrap">
                            <var class="price">145 EUR</var>
                            <small class="text-muted">(145 EUR each)</small>
                        </div> <!-- price-wrap .// -->
                    </td>
                    <td class="text-right">
                        <a href="" class="btn btn-outline-danger"> × Remove</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div> <!-- card.// -->
        <a href="" class="btn btn-outline-success pull-right" style="margin-top: 2%"> Checkout</a>
    </div>



<?php include_once('app/views/layouts/footer.php'); ?>
