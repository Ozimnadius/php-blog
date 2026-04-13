<?php

include_once('init.php');

$pageCanonical = HOST . BASE_URL;
$uri = $_SERVER['REQUEST_URI'];
$badUrl = BASE_URL . 'index.php';

if (strpos($uri, $badUrl) === 0) {
  $cname = 'errors/e404';
} else {
  $routes = include('routes.php');
  $url = $_GET['querysystemurl'] ?? '';

  // Берем сырой путь из реального запроса, а не только из querysystemurl
  $requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '';
  $basePath = '/' . trim(BASE_URL, '/') . '/';
  $rawUrl = preg_replace('#^' . preg_quote($basePath, '#') . '#', '', $requestPath);
  $rawUrl = ltrim((string)$rawUrl, '/');

  // SEO: приводим URL к каноническому виду
  $normalizedUrl = preg_replace('~/+~', '/', $rawUrl);
  $normalizedUrl = trim($normalizedUrl, '/');

  if ($normalizedUrl !== $rawUrl) {
    header('Location: ' . BASE_URL . $normalizedUrl, true, 301);
    exit();
  }

  $routerRes = parseUrl($url, $routes);
  $cname = $routerRes['controller'];
  define('URL_PARAMS', $routerRes['params']);

  $pageCanonical .= $normalizedUrl;

}

$path = "controllers/$cname.php";
$pageTitle = $pageContent = '';

if (!file_exists($path)) {
  $cname = 'errors/e404';
  $path = "controllers/$cname.php";
}

include_once($path);

$html = template('base/v_main', [
  'title' => $pageTitle,
  'content' => $pageContent,
  'canonical' => $pageCanonical
]);

echo $html;