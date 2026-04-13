<?php
declare(strict_types=1);

$id = (int)URL_PARAMS['id'];
$category = getCategoryById($id);

if ($category) {
  $rows = getArticlesByCategoryId($id);

  $menu = template('common/crud_menu', [
    'editUrl' => BASE_URL . 'category/edit/' . $category['id_category'],
    'deleteUrl' => BASE_URL . 'category/delete/' . $category['id_category'],
  ]);

  $content = template('category/index', [
    'category' => $category,
    'rows' => $rows,
  ]);

  $pageTitle = $category['name'];
  $pageContent = template('base/v_con2col', [
    'left' => $menu,
    'content' => $content,
  ]);

} else {
  extract(make404Response());
}


