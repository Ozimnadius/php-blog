<?php
declare(strict_types=1);

$id = (int)URL_PARAMS['id'];
$article = getArticleById($id);

if ($article) {
  $pageTitle = 'Удаление статьи';
  $pageContent = template('common/delete_result', [
    'deleted' => deleteArticle($id),
    'entityName' => 'Статья'
  ]);


} else {
  extract(make404Response());
}
