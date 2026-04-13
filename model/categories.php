<?php
declare(strict_types=1);

/**
 * Возвращает все категории из базы данных
 *
 * @return array Массив категорий, отсортированных по имени
 */
function getAllCategories(): array
{
  $sql = "SELECT * FROM categories ORDER BY name ASC;";
  $query = dbQuery($sql);
  return $query->fetchAll();
}

/**
 * Возвращает категорию по её id
 *
 * @param string $id ID категории
 * @return array|false Массив данных категории или false если не найдена
 */
function getCategoryById(int $id): array|false
{
  $sql = "SELECT * FROM categories WHERE id_category = :id;";
  $query = dbQuery($sql, ['id' => $id]);
  return $query->fetch();
}

function editCategory(int $id, array $fields): void
{
  $sql = "UPDATE categories SET name = :name WHERE id_category = :id_category;";
  $fields['id_category'] = $id;
  $query = dbQuery($sql, $fields);
}

function deleteCategory(int $id): bool
{
  $sql = "DELETE FROM categories WHERE id_category = :id_category;";
  $query = dbQuery($sql, ['id_category' => $id]);
  return $query->rowCount() > 0;
}

function addCategory(array $fields): string
{
  $sql = "INSERT INTO categories (name) VALUES (:name);";
  dbQuery($sql, $fields);
  return dbInstance()->lastInsertId();
}

function categoryValidate(array &$fields): array
{
  $errors = [];

  if (mb_strlen($fields['name'], 'UTF-8') < 2) {
    $errors[] = 'Имя не короче 2 символов!';
  }


  $fields['name'] = htmlspecialchars($fields['name']);

  return $errors;
}

function categoryFields(array $source = []): array
{
  return [
    'name' => trim((string)($source['name'] ?? '')),
  ];
}

