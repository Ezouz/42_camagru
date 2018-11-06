<?php
namespace Core;

class Controller {

  private static $viewPath = 'view/';
  private static $controllerPath = 'controller/';
  private static $modelPath = 'model/';
  private static $layout = 'layout';

  public function header($page){
    if (!(isset($_SESSION['user_id'])))
      return new Header($page, false);
    else
      return new Header($page, true);
  }

  public function setup() {
    require_once('config/config.php');
    $config = \Config\config::getInstance();
    $config->set_db();
  }

  public function render($page) {
    User_controller::get_cookie();
    if ($page !== "404") {
      $error = self::pcm($page);
      if ($error === false)
        return self::render("home");
    $header = self::header($page);
    ob_start();
    require_once(self::$viewPath . $page . '.php');
    $content = ob_get_clean();
    require (self::$viewPath . self::$layout . '.php');
  } else {
    require_once('view/404.php');
  }

  }

  public function autoload() {
    foreach (glob("core/*.php") as $filename)
      require_once ($filename);
    foreach (glob("controller/*.php") as $filename)
      require_once ($filename);
    foreach (glob("model/*.php") as $filename)
      require_once ($filename);
  }

  public function pcm($page) {
    if (file_exists("controller/".$page.".php")) {
      $control = "\\Controller\\" . $page;
      $controller = new $control();
      if (method_exists($control, $page)) {
        $error = $controller->$page();
        return $error;
      }
    } else
      return false;
  }

  public function display_error($error) {
    $msg = '<div id="error">';
    $msg .= '<div id="error_msg">';
    $msg .= '<p class="error_txt">'.$error.'</p>';
    $msg .= '</div>';
    $msg .= '</div>';
    echo $msg;
  }

}
