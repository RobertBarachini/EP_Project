<?php include_once('app/views/layouts/header.php'); ?>
<?php $stevecZaCene = 0; foreach ($narocilaPodatki as $key => $value): ?>

    <div class="container">
        <div class="row">
            <div class="table-responsive">
                <h2>ID Narocila: <?= $value['idnarocila'] ?></h2>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Ime Artikla</th>
                        <th>Datum Narocila</th>
                        <th>Kolicina</th>
                        <th>Cena</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $neki = 0; $temp = 0;
                    foreach ($value as $ke): ?>
                      <?php if (is_array($ke) == true)  {
                        echo "
                            <tr>
                                <td>  {$temp} </td>
                                <td><a href=\"/artikli/{$ke['idartikla']}\" target=\"_blank\"> {$ke['1']}</a></td>
                                <td>{$value['datzac_kosarice']}</td>
                                <td>{$ke['kolicina']}</td>
                                <td>{$ke['0']} € each</td>
                                ";
                        if($value['faza'] == 'N')
                            echo "
                                <td><span class=\"badge badge-primary\">V OBRAVNAVI</span></td>
                            </tr>                      
                          ";
                        if($value['faza'] == 'P')
                          echo "
                                <td><span class=\"badge badge-success\">POSLANO</span></td>
                            </tr>                       
                          ";
                        if($value['faza'] == 'Z')
                          echo "
                                <td><span class=\"badge badge-danger\">ZAVRNJENO</span></td>
                            </tr>                       
                          ";
                        if($value['faza'] == 'S')
                          echo "
                                <td><span class=\"badge badge-warning\">STORNIRANO</span></td>
                            </tr>                       
                          ";
                        $temp += 1;
                      }
                      ?>
                      <?php $neki += 1; endforeach; ?>
                    </tbody>
                </table>
                <div class='float-right'>
                    <h6>Skupna cena: <?= $ceneSkupne[$stevecZaCene]?> €</h6>
                </div>
            </div>
        </div>
    </div>
<?php $stevecZaCene +=1; endforeach; ?>


<?php include_once('app/views/layouts/footer.php'); ?>