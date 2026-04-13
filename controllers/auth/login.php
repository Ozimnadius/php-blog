<?php
declare(strict_types=1);
csrfValidate();
// Если уже залогинен — на главную
if (isset($_SESSION['user_id'])) {
  header('Location: ' . BASE_URL);
  exit();
}

$fields = userFields($_POST);
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Ищем пользователя в БД
  $user = getUserByEmail($fields['email']);

  // Проверяем пароль
  if (!$user || !password_verify($fields['password'], $user['password_hash'])) {
    $errors[] = 'Неверный email или пароль';
  }

  // Если ошибок нет — логиним
  if (empty($errors)) {
    session_regenerate_id(true);
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['email']   = $user['email'];

    // Берём сохранённый адрес или идём на главную
    $redirect = $_SESSION['redirect_after_login'] ?? BASE_URL;
    unset($_SESSION['redirect_after_login']); // Чистим за собой

    header('Location: ' . $redirect);
    exit();
  }
}

$pageTitle = 'Вход';
$pageContent = template('auth/v_login', [
  'fields' => $fields,
  'errors' => $errors,
]);