<?php
declare(strict_types=1);
$rows = getAllCategories();

$pageTitle = 'Main';
$pageContent = template("index", [
  'rows' => $rows
]);