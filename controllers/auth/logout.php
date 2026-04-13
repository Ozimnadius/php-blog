<?php
declare(strict_types=1);

// 1. Очищаем массив сессии
unset($_SESSION['user_id']);
unset($_SESSION['email']);

// 2. Удаляем куку сессии из браузера
if (isset($_COOKIE[session_name()])) {
  setcookie(session_name(), '', time() - 3600, '/');
}

// 3. На главную
header('Location: ' . BASE_URL);
exit();