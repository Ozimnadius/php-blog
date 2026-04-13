<?php
declare(strict_types=1);
requireAuth();
csrfValidate();
$id = (int)URL_PARAMS['id'];
$category = getCategoryById($id);

if ($category) {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fields = categoryFields($_POST);
    $validateErrors = categoryValidate($fields);

    if (empty($validateErrors)) {
      editCategory($id, $fields);
      header("Location:" . BASE_URL . "category/$id");
      exit();
    }
  } else {
    $fields = categoryFields($category);
    $validateErrors = [];
  }

  $pageTitle = 'Edit category';
  $fieldsContent = template('category/_fields', [
    'fields' => $fields
  ]);
  $pageContent = template('common/form_layout', [
    'fieldsContent' => $fieldsContent,
    'validateErrors' => $validateErrors
  ]);

} else {
  extract(make404Response());
}
