<?php
namespace Core;

class Page {

  public $nb_p;
  public $current;
  public $nav;
  public $page;
  private $bypage = 6;
  private static $model;

  public function __construct($page, $p) {
    $this->page = (empty($page) ?  "home" : $page);
    $this->current = (empty($p) ? 1 : intval($p, 10));
      self::get_model();
      self::get_nb_post($page);
      self::pagination();
  }

  protected function get_model() {
    if (self::$model === null)
      self::$model = new \Core\Post_model();
    return self::$model;
  }

  public function get_nb_post($page) {
    $stmt = "SELECT COUNT(*) FROM `posts` WHERE ";
    $stmt .= (($page === "home") ? "" : '`user_id` LIKE :user_id AND ');
    $stmt .= "`img_modif_date` IS NOT NULL;";
    $attributes = ($this->page === "home" ? null : (array('user_id' =>
                                          (isset($_SESSION['user_id'])
                                          ? $_SESSION['user_id'] : null))
                                        ));
    $aro = get_object_vars(self::$model->count_post($stmt, $attributes));
    $this->nb_p = $aro["COUNT(*)"];
  }

  public function pagination() {
    $this->nav = '<div class="pagination">';
    $n = 1;
    while ($n < ($this->nb_p / $this->bypage)) {
      $this->nav .= '<a href="index.php?page='.$this->page.'&p='.$n;
      $this->nav .= '"'.($this->current === $n ? 'class="active"' : '').'>'.$n.'</a>';
      $n++;
    }
    if ($this->nb_p % $this->bypage !== 0) {
      $this->nav .= '<a href="index.php?page='.$this->page.'&p='.$n;
      $this->nav .= '"'.($this->current === $n ? 'class="active"' : '').'>'.$n.'</a>';
    }
    $this->nav .= '</div>';
  }

  public function get_slice() {
    $this->current * $this->bypage;
    $beg = (($this->current - 1) * $this->bypage);
    $stmt = "SELECT * FROM `posts` WHERE `img_modif_date` IS NOT NULL";
    $stmt .= ($this->page === "home" ? "" : " AND `user_id` LIKE :user_id");
    $stmt .= " ORDER BY `img_creation_date` DESC LIMIT ";
    $stmt .= ($beg === 0 ? "" : $beg.", ") . " " . $this->bypage;
    $attributes = ($this->page === "home" ? null : (array('user_id' =>
                                          (isset($_SESSION['user_id'])
                                          ? $_SESSION['user_id'] : null))
                                        ));
    return (self::$model->display_post(self::$model->get_posts($stmt, $attributes)));
  }

  function __toString() {
    return $this->nav;
  }

}
