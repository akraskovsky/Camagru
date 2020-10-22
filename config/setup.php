<?php
include "database.php";

try {
  $pdo = new PDO($DB_DSN_SHORT, $DB_USER, $DB_PASSWORD);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  echo "CAMAGRU: Database connection established.<br>";
}
catch(PDOException $ex){
  die ("CAMAGRU: Failed database connection");
}

$db = "CREATE DATABASE IF NOT EXISTS $DB_NAME; USE $DB_NAME;";

$usersTable = "CREATE TABLE IF NOT EXISTS `users`(
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(15) NOT NULL ,
  `mail` VARCHAR(50) NOT NULL ,
  `password` VARCHAR(150) NOT NULL ,
  `activated` BOOLEAN NOT NULL DEFAULT FALSE,
  `notify` BOOLEAN NOT NULL DEFAULT TRUE,
  `token` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`)) ENGINE = InnoDB;";

$imgTable = "CREATE TABLE IF NOT EXISTS `images`(
  `id` INT NOT NULL AUTO_INCREMENT ,
  `date` DATE NOT NULL ,
  `id_user` INT NOT NULL ,
  `file` VARCHAR(140) NOT NULL ,
  PRIMARY KEY (`id`)) ENGINE = InnoDB;";

$likesTable = "CREATE TABLE IF NOT EXISTS `likes`(
  `id` INT NOT NULL AUTO_INCREMENT ,
  `id_img` INT NOT NULL ,
  `id_user` INT NOT NULL ,
  PRIMARY KEY (`id`)) ENGINE = InnoDB;";

$commentsTable = "CREATE TABLE IF NOT EXISTS `comments`(
  `id` INT NOT NULL AUTO_INCREMENT ,
  `id_img` INT NOT NULL ,
  `id_user` INT NOT NULL ,
  `text` VARCHAR(140) NOT NULL ,
  PRIMARY KEY (`id`)) ENGINE = InnoDB;";

try {
  $pdo->exec($db . $usersTable . $imgTable . $likesTable . $commentsTable);
  echo "CAMAGRU: Database structure created.<br>";
}
catch(PDOException $ex){
  die ("CAMAGRU: Failed database creation");
}
?>