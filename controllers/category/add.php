<?php
declare(strict_types=1);
requireAuth();
csrfValidate();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $fields = categoryFields($_POST);
  $validateErrors = categoryValidate($fields);

  if (empty($validateErrors)) {
    $id = addCategory($fields);
    header("Location:".BASE_URL."category/$id");
    exit();
  }
} else {
  $fields = categoryFields();
  $validateErrors = [];
}

$pageTitle = 'Add category';
$fieldsContent = template('category/_fields', [
  'fields' => $fields
]);
$pageContent = template('common/form_layout', [
  'fieldsContent' => $fieldsContent,
  'validateErrors' => $validateErrors
]);
