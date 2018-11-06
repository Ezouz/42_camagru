<?php
namespace Core;

class User {

  public $user_id;
  public $login;
  public $email;
  public $passwd;
  public $status;
  public $token_pwd;
  public $token_mail;
  public $user_bio;
  public $profil_pic;

  public function __construct(array $data)
  {
    $this->hydrate($data);
  }

  public function hydrate(array $data) {
    foreach ($data as $key => $value)
    {
      $method = 'set'.ucfirst($key);
      if (method_exists($this, $method))
        $this->$method($value);
    }
  }

  private function setUser_id($val) { $this->user_id = $val; }
  private function setLogin($val) { $this->login = $val; }
  private function setEmail($val) { $this->email = $val; }
  private function setUser_bio($val) { $this->user_bio = $val; }
  private function setProfil_pic($val) { $this->profil_pic = $val; }
  private function setPasswd($val) { $this->passwd = $val; }
  private function setStatus($val) { $this->status = $val; }
  private function setToken_pwd($val) { $this->token_pwd = $val; }
  private function setToken_mail($val) { $this->token_mail = $val; }

  public function getUser_id() { return $this->user_id; }
  public function getLogin() { return $this->login; }
  public function getEmail() { return $this->email; }
  public function getUser_bio() { return $this->user_bio; }
  public function getProfil_pic() { return $this->profil_pic; }
  public function getStatus() { return $this->status; }
  public function getPasswd() { return $this->passwd; }
  public function getToken_pwd() { return $this->token_pwd; }
  public function getToken_mail() { return $this->token_mail; }

}
