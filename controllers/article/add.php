<?php
declare(strict_types=1);
requireAuth();
csrfValidate();
$categories = getAllCategories();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fields = articleFields($_POST);
  $validateErrors = articleValidate($fields);

  if (empty($validateErrors)) {
    $id = addArticle($fields);
    header("Location:".BASE_URL."article/$id");
    exit();
  }
} else {
  $fields = articleFields();
  $validateErrors = [];
}

$pageTitle = 'Add article';
$fieldsContent = template('article/_fields', [
  'fields' => $fields,
  'categories' => $categories
]);
$pageContent = template('common/form_layout', [
  'fieldsContent' => $fieldsContent,
  'validateErrors' => $validateErrors
]);