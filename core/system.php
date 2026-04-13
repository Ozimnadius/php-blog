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
    // Запоминаем куда хотел попасть
    $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
    header('Location: ' . BASE_URL . 'login');
    exit();
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

  $tokenFromForm    = $_POST['csrf_token'] ?? '';
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