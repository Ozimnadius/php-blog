<?php
declare(strict_types=1);

$id = (int)URL_PARAMS['id'];
$article = getArticleById($id);
$categories = getAllCategories();

if ($article) {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = articleFields($_POST);
    $validateErrors = articleValidate($fields);

    if (empty($validateErrors)) {
      editArticle($id, $fields);
      header("Location:" . BASE_URL . "article/$id");
      exit();
    }
  } else {
    $fields = articleFields($article);
    $validateErrors = [];
  }

  $pageTitle = 'Edit article';
  $fieldsContent = template('article/_fields', [
    'fields' => $fields,
    'categories' => $categories
  ]);
  $pageContent = template('common/form_layout', [
    'fieldsContent' => $fieldsContent,
    'validateErrors' => $validateErrors
  ]);

} else {
  extract(make404Response());
}
