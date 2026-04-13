<?php
declare(strict_types=1);

/**
 * Ищет пользователя по email
 *
 * @param string $email
 * @return array|false Данные пользователя или false если не найден
 */
function getUserByEmail(string $email): array|false
{
  $sql = "SELECT * FROM users WHERE email = :email;";
  $query = dbQuery($sql, ['email' => $email]);
  return $query->fetch();
}

/**
 * Создаёт нового пользователя
 *
 * @param array $fields Массив с полями: email, password_hash
 * @return string ID созданного пользователя
 */
function addUser(array $fields): string
{
  $sql = "INSERT INTO users (email, password_hash) VALUES (:email, :password_hash);";
  dbQuery($sql, $fields);
  return dbInstance()->lastInsertId();
}

/**
 * Валидирует поля формы регистрации/логина
 *
 * @param array $fields
 * @return array Массив ошибок (пустой если всё ок)
 */
function userValidate(array $fields): array
{
  $errors = [];

  if (!filter_var($fields['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Некорректный email';
  }

  if (mb_strlen($fields['password'], 'UTF-8') < 8) {
    $errors[] = 'Пароль не короче 8 символов';
  }

  return $errors;
}

/**
 * Фильтрует и нормализует поля из $_POST
 *
 * @param array $source
 * @return array
 */
function userFields(array $source = []): array
{
  return [
    'email' => trim(strtolower((string)($source['email'] ?? ''))),
    'password' => trim((string)($source['password'] ?? '')),
  ];
}