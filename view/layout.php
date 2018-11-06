<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,height=device-height,initial-scale=1.0"/>
  <title>CAMAGRU</title>
  <link href="css/theme.css" rel="stylesheet" type="text/css">
  <link href='https://fonts.googleapis.com/css?family=Permanent Marker' rel='stylesheet'>
</head>
<body>
<div id="general">
  <header id="navbar">
    <?php if (isset($header))
          echo $header;
     ?>
  </header>
  <div id="down_navbar">
    <?php
    if (isset($error) && !is_bool($error))
       \Core\Controller::display_error($error);
    if (isset($_SESSION['log'])) {
      \Core\Controller::display_error($_SESSION['log']);
      unset($_SESSION['log']);
    }
    ?>
    <?= $content ?>
  </div>
  <footer id="footer">
    <div id="auteur">&copy; ehouzard</div>
  </footer>
</div>
</body>
</html>
