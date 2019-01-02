<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> <?= $this->siteTitle()?> </title>
    <link href="/MainApp/statics/css/bootstrap.min.css" rel="stylesheet">
    <link href="/MainApp/statics/css/style.css" rel="stylesheet">
    <script src="/MainApp/statics/js/jquery-3.3.1.min.js"></script>
    <script src="/MainApp/statics/js/bootstrap.min.js"></script>

    <?= $this->content('head')?>

  </head>
  <body>
    <?= $this->content('body')?>
  </body>
</html>