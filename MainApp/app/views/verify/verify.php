<?php include_once('app/views/layouts/header.php');?>

<?php if($zeObstaja == 1)
   echo "
  <div style='position: fixed;
    top: 50%;
    left: 50%;
    margin-top: -100px;
    margin-left: -200px; '> 
    <h1><span class=\"badge badge-success\">Hvala! Sedaj lahko začnete uporabljati vaš račun!</span></h1>
  </div>
  ";
?>
<?php if($zeObstaja == 0)
  echo "
  <div style='position: fixed;
    top: 50%;
    left: 50%;
    margin-top: -100px;
    margin-left: -200px; '> 
    <h1><span class=\"badge badge-primary\">Vaš račun ste že potrdili!</span></h1>
  </div>
  ";
?>

<?php include_once('app/views/layouts/footer.php');?>
