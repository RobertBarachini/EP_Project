<?php
// Create database connection
$db = mysqli_connect("localhost", "root", "ep", "trgovina");

// Initialize message variable
$msg = "";

// If upload button is clicked ...
if (isset($_POST['upload'])) {
  // Get image name
  $image = $_FILES['image']['name'];
  // Get text
  $image_naziv = mysqli_real_escape_string($db, $_POST['naziv']);
  $image_idartikla = mysqli_real_escape_string($db, $_POST['idartikla']);

  // image file directory
  $target = "images/".basename($image);

  $sql = " INSERT INTO trgovina.artikli_slike (idartikla, naziv, link, status,idspr) VALUES ('$image_idartikla','$image_naziv' ,'$image',1,-1)";
  // execute query
  mysqli_query($db, $sql);

  if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
    $msg = "Image uploaded successfully";
  }else{
    $msg = "Failed to upload image";
  }
}
$result = mysqli_query($db, "SELECT * FROM trgovina.artikli_slike");
?>
<!DOCTYPE html>
<html>
<head>
  <title>Image Upload</title>
  <style type="text/css">
    #content{
      width: 50%;
      margin: 20px auto;
      border: 1px solid #cbcbcb;
    }
    form{
      width: 50%;

      margin: 20px auto;
    }
    form div{
      margin-top: 5px;
    }
    #img_div{
      width: 80%;
      padding: 5px;
      margin: 15px auto;
      border: 1px solid #cbcbcb;
    }
    #img_div:after{
      content: "";
      display: block;
      clear: both;
    }
    img{
      float: left;
      margin: 5px;
      width: 300px;
      height: 140px;
    }
  </style>
</head>
<body>
<div id="content">
  <?php
  $_POST = "";
  while ($row = mysqli_fetch_array($result)) {
    echo "<div id='img_div'>";
    echo "<img src='images/".$row['link']."' >";
    echo "<p>".$row['naziv']."</p>";
    echo "</div>";
  }
  ?>
  <form method="POST" action="/PRODAJALEC" enctype="multipart/form-data">
    <div>
      <input type="file" name="image">
    </div>
    <div>
      <input type="text" name="idartikla"> id artikla <br>
      <input type="text" name="naziv"> ime slike
    </div>
    <div>
      <button type="submit" name="upload">POST</button>
    </div>
  </form>
</div>
</body>
</html>