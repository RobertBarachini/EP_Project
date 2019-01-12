<?php include_once('app/views/layouts/header.php');?>

<?php if($zeObstaja == 1)
  echo "Hvala za Potrditev!";
  ?>
<?php if($zeObstaja == 0)
  echo "Ste ze potrdili!";
?>

<?php include_once('app/views/layouts/footer.php');?>
