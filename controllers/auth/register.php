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

  // Валидируем поля
  $errors = userValidate($fields);

  if (empty($errors)) {
    // Проверяем что email не занят
    $existing = getUserByEmail($fields['email']);

    if ($existing) {
      $errors[] = 'Этот email уже зарегистрирован';
    }
  }

  if (empty($errors)) {
    // Хешируем пароль и сохраняем
    $id = addUser([
      'email'         => $fields['email'],
      'password_hash' => password_hash($fields['password'], PASSWORD_DEFAULT),
    ]);

    // Сразу логиним после регистрации
    session_regenerate_id(true);
    $_SESSION['user_id'] = $id;
    $_SESSION['email']   = $fields['email'];
    $_SESSION['role']    = 'reader';

    header('Location: ' . BASE_URL);
    exit();
  }
}

$pageTitle = 'Регистрация';
$pageContent = template('auth/v_register', [
  'fields' => $fields,
  'errors' => $errors,
]);