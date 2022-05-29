<?php

use Core\App;

require_once __DIR__ . '/vendor/autoload.php';
Dotenv\Dotenv::createUnsafeImmutable(__DIR__)->load();

$app = new App(__DIR__);
$pdo = App::app()->pdo();

$pdo->exec('CREATE TABLE `tasks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `body` text NOT NULL,
  `is_done` tinyint(1) NOT NULL,
  `is_edited` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
);');

$pdo->exec('CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(300) NOT NULL,
  `password` varchar(300) NOT NULL,
  PRIMARY KEY (`id`)
);');

$pdo->exec('INSERT INTO `users` (`username`, `password`) VALUES ("admin", "' . password_hash('123', PASSWORD_BCRYPT) . '");');
