<?php
$DB_DRIVER = "mysql";
$DB_NAME = "camagru";
$DB_USER = "root";
$DB_PASS = "password";
$DB_HOST = "localhost";
$DB_DNS = $DB_DRIVER.":host=".$DB_HOST;

return array(
"driver" => $DB_DRIVER,
"host" => $DB_HOST,
"username" => $DB_USER,
"password" => $DB_PASS,
"dbname" => $DB_NAME,
"dns" => $DB_DNS
);
