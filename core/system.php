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
