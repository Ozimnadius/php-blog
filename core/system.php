<?php

function template(string $path, array $vars = []): string
{
  $systemTemplateRenererIntoFullPath = "views/$path.php";
  extract($vars);
  ob_start();
  include($systemTemplateRenererIntoFullPath);
  return ob_get_clean();
}

function parseUrl(string $url, array $routes): array
{
  $res = [
    'controller' => 'errors/e404',
    'params' => []
  ];

  foreach ($routes as $route) {
    $matches = [];

    if (preg_match($route['test'], $url, $matches)) {
      $res['controller'] = $route['controller'];

      if (isset($route['params'])) {
        foreach ($route['params'] as $name => $num) {
          $res['params'][$name] = $matches[$num];
        }
      }

      break;
    }
  }
  // find route, parse params

  return $res;
}

function make404Response(string $title = 'Ошибка 404'): array
{
  $protocol = $_SERVER['SERVER_PROTOCOL'] ?? 'HTTP/1.1';
  header("$protocol 404 Not Found");
  return [
    'pageTitle' => $title,
    'pageContent' => template('errors/v_404')
  ];
}

function requireAuth(): void
{
  if (!isset($_SESSION['user_id'])) {
    // Пробуем автологин через remember-токен
    if (loginByRememberToken()) {
      return; // Залогинились через куку — продолжаем
    }

    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header('Location: ' . BASE_URL . 'login');
    exit();
  }
}

function requireRole(string $role): void
{
  requireAuth(); // Сначала проверяем что залогинен

  if ($_SESSION['role'] !== $role) {
    http_response_code(403);
    die('Доступ запрещён');
  }
}

function csrfToken(): string
{
  if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
  }
  return $_SESSION['csrf_token'];
}

function csrfValidate(): void
{
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    return;
  }

  $tokenFromForm = $_POST['csrf_token'] ?? '';
  $tokenFromSession = $_SESSION['csrf_token'] ?? '';

  if (empty($tokenFromForm) || !hash_equals($tokenFromSession, $tokenFromForm)) {
    http_response_code(419);
    die('Недействительный токен. Обновите страницу и попробуйте снова.');
  }
}

function csrfField(): string
{
  return '<input type="hidden" name="csrf_token" value="'
    . csrfToken() . '">';
}

function setRememberMeCookie(int $userId): void
{
  $token = bin2hex(random_bytes(32)); // Случайный токен
  $hash = hash('sha256', $token);   // Хешируем для БД
  $expires = time() + 86400 * 30;      // 30 дней

  // Сохраняем хеш в БД
  saveRememberToken(
    $userId,
    $hash,
    date('Y-m-d H:i:s', $expires)
  );

  // Отправляем сам токен в куку
  setcookie('remember_token', $token, [
    'expires' => $expires,
    'path' => '/',
    'httponly' => true,  // JS не может прочитать — защита от XSS
    'samesite' => 'Lax', // Защита от CSRF
  ]);
}

function loginByRememberToken(): bool
{
  $token = $_COOKIE['remember_token'] ?? null;
  if (!$token) return false;

  $hash = hash('sha256', $token);
  $user = getUserByRememberToken($hash);

  if (!$user) return false;

  // Удаляем старый токен — выдаём новый
  // Это называется ротация токена
  deleteRememberToken($hash);
  setRememberMeCookie($user['id']);

  // Логиним
  session_regenerate_id(true);
  $_SESSION['user_id'] = $user['id'];
  $_SESSION['email'] = $user['email'];
  $_SESSION['role']    = $user['role'];

  return true;
}