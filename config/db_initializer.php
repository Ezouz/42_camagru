<?php
namespace Config;
use \PDO;

class db_initializer {

    private $DB_DRIVER;
    private $DB_NAME;
    private $DB_USER;
    private $DB_PASS;
    private $DB_HOST;
    private $DB_DNS;
    private $_pdo;

    public function __construct (Config $settings) {
      $this->DB_DRIVER = $settings->get("driver");
      $this->DB_HOST = $settings->get("host");
      $this->DB_USER = $settings->get("username");
      $this->DB_PASS = $settings->get("password");
      $this->DB_NAME = $settings->get("dbname");
      $this->DB_DNS = $settings->get("dns").";";
      $this->getPDO();
      $this->create_db();
      $this->create_dbtusers();
      $this->create_dbtposts();
      $this->create_dbtcomments();
      $this->create_dbtlikes();
    }

    private function getPDO() {
      if  ($this->_pdo === null) {
        $pdo = new PDO($this->DB_DNS,
    										$this->DB_USER,
    										$this->DB_PASS
    									);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->_pdo = $pdo;
      }
      return ($this->_pdo);
    }

  	private function create_db() {
  		try {
    			$this->_pdo->exec("CREATE DATABASE IF NOT EXISTS `camagru`;");
    		} catch (Exception $e) {
    			echo 'Unable to create database. '.$e->getCode();
    		}
  	}

  	private function create_dbtusers() {
  		try {
  			$this->_pdo->exec("CREATE TABLE IF NOT EXISTS camagru.users
    												( `user_id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
    													`login` VARCHAR(50) NOT NULL,
    													`passwd` VARCHAR(150) NOT NULL,
    													`email` VARCHAR(50) NOT NULL,
    													`token_mail` VARCHAR(20) NOT NULL,
    													`token_pwd` VARCHAR(20) NOT NULL,
    													`status` INT(1),
                              `notif` INT(1)
                            ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ;");
    		} catch (Exception $e) {
    			 echo 'Unable to create database.users. '.$e->getCode();
    		}
  	}

  	private function create_dbtposts() {
    		try {
    			$this->_pdo->exec("CREATE TABLE IF NOT EXISTS camagru.posts
    												( `img_id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
                              `user_id` INT(1) NOT NULL,
                              `login` VARCHAR(50) NOT NULL,
                              `img_title` VARCHAR(50),
    													`img_desc` VARCHAR(200),
                              `img_path` VARCHAR(200) NOT NULL,
                              `img_creation_date` DATETIME,
                              `img_modif_date` DATETIME
                            ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
    		} catch (Exception $e) {
    			 echo 'Unable to create database.posts. '.$e->getCode();
    		}
  	}

  	private function create_dbtcomments() {
    		try {
    			$this->_pdo->exec("CREATE TABLE IF NOT EXISTS camagru.comments
    											( `comment_id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
                            `user_id` INT(1) NOT NULL,
                            `login` VARCHAR(50) NOT NULL,
                            `img_id` INT(1) NOT NULL,
                            `comment` VARCHAR(200) NOT NULL,
                            `comment_date` DATETIME
                          ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ;");
    		} catch (Exception $e) {
    			 echo 'Unable to create database.comments. '.$e->getCode();
    		}
    }

    private function create_dbtlikes() {
        try {
          $this->_pdo->exec("CREATE TABLE IF NOT EXISTS camagru.likes
                          ( `like_id` INT PRIMARY KEY AUTO_INCREMENT NOT NULL,
                            `user_id` INT(1) NOT NULL,
                            `img_id` INT(1) NOT NULL
                          );");
        } catch (Exception $e) {
           echo 'Unable to create database.likes. '.$e->getCode();
        }
    }

}
