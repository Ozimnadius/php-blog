<?php
declare(strict_types=1);

csrfValidate();
requireRole('admin');

$id = (int)URL_PARAMS['id'];
$category = getCategoryById($id);

if ($category) {
  $pageTitle = 'Удаление категории';
  $pageContent = template('common/delete_result', [
    'deleted' => deleteCategory($id),
    'entityName' => 'Категория'
  ]);

} else {
  extract(make404Response());
}
