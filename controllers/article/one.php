<?php
declare(strict_types=1);

$id = (int)URL_PARAMS['id'];
$article = getArticleById($id);


if ($article) {
  $menu = template('common/crud_menu', [
    'editUrl' => BASE_URL . 'article/edit/' . $article['id_article'],
    'deleteUrl' => BASE_URL . 'article/delete/' . $article['id_article'],
  ]);


  $content = template('article/index', [
    'article' => $article,
    'category' => getCategoryById($article['id_category']),
  ]);

  $pageTitle = $article['title'];
  $pageContent = template('base/v_con2col', [
    'left' => $menu,
    'content' => $content,
  ]);

} else {
  extract(make404Response());
}

