<?php
session_start();
define ('ROOT', dirname(__DIR__) . '/camagru/');
require_once('core/Controller.php');
\Core\Controller::autoload();
\Core\Controller::setup();
if (isset($_GET['page'])) {
  $page = $_GET['page'];
} else {
  $page = 'home';
}
\Core\Controller::render($page);
