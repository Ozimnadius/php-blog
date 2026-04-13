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

/**
 * Сохраняет remember-токен в БД
 *
 * @param int $userId
 * @param string $tokenHash хеш токена
 * @param string $expiresAt дата истечения
 * @return void
 */
function saveRememberToken(int $userId, string $tokenHash, string $expiresAt): void
{
  $sql = "INSERT INTO remember_tokens (user_id, token_hash, expires_at) 
            VALUES (:user_id, :token_hash, :expires_at)";
  dbQuery($sql, [
    'user_id' => $userId,
    'token_hash' => $tokenHash,
    'expires_at' => $expiresAt,
  ]);
}

/**
 * Ищет токен в БД и возвращает пользователя
 *
 * @param string $tokenHash
 * @return array|false
 */
function getUserByRememberToken(string $tokenHash): array|false
{
  $sql = "SELECT u.* FROM users u
            JOIN remember_tokens rt ON rt.user_id = u.id
            WHERE rt.token_hash = :token_hash 
            AND rt.expires_at > NOW()";
  $query = dbQuery($sql, ['token_hash' => $tokenHash]);
  return $query->fetch();
}

/**
 * Удаляет токен из БД
 *
 * @param string $tokenHash
 * @return void
 */
function deleteRememberToken(string $tokenHash): void
{
  $sql = "DELETE FROM remember_tokens WHERE token_hash = :token_hash";
  dbQuery($sql, ['token_hash' => $tokenHash]);
}