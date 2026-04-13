<?php
declare(strict_types=1);

/**
 * Возвращает все статьи из указанной категории
 *
 * @param int $id ID категории
 * @return array Массив статей
 */
function getArticlesByCategoryId(int $id): array
{
  $sql = "SELECT * FROM articles WHERE id_category = :id_category ORDER BY created_at DESC;";
  $query = dbQuery($sql, ['id_category' => $id]);
  return $query->fetchAll();
}

/**
 * Возвращает статью по её ID
 *
 * @param int $id ID статьи
 * @return array|false Массив данных статьи или false если не найдена
 */
function getArticleById(int $id): array|false
{
  $sql = "SELECT * FROM articles WHERE id_article = :id_article;";
  $query = dbQuery($sql, ['id_article' => $id]);
  return $query->fetch();
}

/**
 * Удаляет статью по её ID
 *
 * @param int $id ID статьи
 * @return bool True если удаление успешно, false если статья не найдена
 */
function deleteArticle(int $id): bool
{
  $sql = "DELETE FROM articles WHERE id_article = :id_article;";
  $query = dbQuery($sql, ['id_article' => $id]);
  return $query->rowCount() > 0;
}

/**
 * Обновляет данные существующей статьи
 *
 * @param array $fields Массив с полями статьи:
 *   - id_article: ID статьи
 *   - id_category: ID категории
 *   - title: Заголовок
 *   - slug: Slug
 *   - content: Содержание
 * @return void
 */
function editArticle(int $id, array $fields): void
{
  $sql = "UPDATE articles SET id_category = :id_category, title = :title, content = :content WHERE id_article = :id_article;";
  $fields['id_article'] = $id;
  $query = dbQuery($sql, $fields);
}

/**
 * Добавляет новую статью в базу данных
 *
 * @param array $fields Массив с полями статьи:
 *   - id_category: ID категории
 *   - title: Заголовок
 *   - slug: Slug
 *   - content: Содержание
 * @return string
 */
function addArticle(array $fields): string
{
  $sql = "INSERT INTO articles (id_category, title, content) VALUES (:id_category, :title, :content);";
  dbQuery($sql, $fields);
  return dbInstance()->lastInsertId();
}

function articleValidate(array &$fields): array
{
  $errors = [];
  $textLen = mb_strlen($fields['content'], 'UTF-8');

  if (mb_strlen($fields['title'], 'UTF-8') < 2) {
    $errors[] = 'Имя не короче 2 символов!';
  }

  if ($textLen < 10 || $textLen > 140) {
    $errors[] = 'Текст от 10 до 140 символов!';
  }

  $fields['title'] = htmlspecialchars($fields['title']);
  $fields['content'] = htmlspecialchars($fields['content']);

  return $errors;
}

function articleFields(array $source = []): array
{
  return [
    'title' => trim((string)($source['title'] ?? '')),
    'id_category' => trim((string)($source['id_category'] ?? '')),
    'content' => trim((string)($source['content'] ?? '')),
  ];
}
