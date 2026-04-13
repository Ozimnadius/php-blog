<?php
session_start();
const HOST = 'http://localhost';
const BASE_URL = '/';

const DB_HOST = 'mysql-8.0';
const DB_NAME = 'php-blog';
const DB_USER = 'root';
const DB_PASS = '';

include_once('core/db.php');
include_once('core/system.php');

include_once('model/articles.php');
include_once('model/categories.php');
include_once('model/users.php');

// Автологин через remember-токен на любой странице
if (!isset($_SESSION['user_id'])) {
  loginByRememberToken();
}