<?php
declare(strict_types=1);
csrfValidate();
// 1. Очищаем массив сессии
unset($_SESSION['user_id']);
unset($_SESSION['email']);

// Удаляем remember-токен если есть
if (isset($_COOKIE['remember_token'])) {
  $hash = hash('sha256', $_COOKIE['remember_token']);
  deleteRememberToken($hash);
  setcookie('remember_token', '', time() - 3600, '/');
}

// 2. Удаляем куку сессии из браузера
if (isset($_COOKIE[session_name()])) {
  setcookie(session_name(), '', time() - 3600, '/');
}

// 3. На главную
header('Location: ' . BASE_URL);
exit();