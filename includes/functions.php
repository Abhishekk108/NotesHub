<?php
// includes/functions.php
// Shared application helpers and database bootstrap.

if (!defined('APP_NAME')) {
    define('APP_NAME', 'Noteshub');
}

if (!defined('BASE_PATH')) {
    define('BASE_PATH', dirname(__DIR__));
}

if (!defined('BASE_URL')) {
    define('BASE_URL', '/noteshub/');
}

require_once BASE_PATH . '/config/db.php';

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

function sanitize(string $value): string
{
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

function formatDate(string $value, string $format = 'F j, Y g:i A'): string
{
    try {
        $date = new DateTime($value);
        return $date->format($format);
    } catch (Exception $e) {
        return sanitize($value);
    }
}

function truncateText(string $text, int $length = 120, string $ending = '...'): string
{
    $text = trim($text);
    if (mb_strlen($text) <= $length) {
        return $text;
    }

    return mb_substr($text, 0, $length - mb_strlen($ending)) . $ending;
}

function getTotalNotes(): int
{
    global $pdo;
    $stmt = $pdo->query('SELECT COUNT(*) FROM notes');
    return (int) $stmt->fetchColumn();
}

function getTotalCategories(): int
{
    global $pdo;
    $stmt = $pdo->query('SELECT COUNT(*) FROM categories');
    return (int) $stmt->fetchColumn();
}

function getRecentNotes(int $limit = 5): array
{
    global $pdo;
    $stmt = $pdo->prepare(
        'SELECT n.id, n.title, n.content, n.created_at, n.updated_at, c.name AS category_name
         FROM notes n
         JOIN categories c ON n.category_id = c.id
         ORDER BY n.created_at DESC
         LIMIT :limit'
    );
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll();
}

function noteExists(int $id): bool
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT 1 FROM notes WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    return (bool) $stmt->fetchColumn();
}

function categoryExists(int $id): bool
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT 1 FROM categories WHERE id = ? LIMIT 1');
    $stmt->execute([$id]);
    return (bool) $stmt->fetchColumn();
}

function getAllNotes(): array
{
    global $pdo;
    $stmt = $pdo->prepare(
        'SELECT n.id, n.title, n.content, n.created_at, n.updated_at, c.name AS category_name, c.id AS category_id
         FROM notes n
         JOIN categories c ON n.category_id = c.id
         ORDER BY n.updated_at DESC'
    );
    $stmt->execute();
    return $stmt->fetchAll();
}

function searchNotes(string $query = '', int $categoryId = 0): array
{
    global $pdo;

    $conditions = [];
    $params     = [];

    if ($query !== '') {
    $conditions[] = '(n.title LIKE :title_query OR n.content LIKE :content_query)';

    $params[':title_query'] = '%' . $query . '%';
    $params[':content_query'] = '%' . $query . '%';
}

    if ($categoryId > 0) {
        $conditions[] = 'n.category_id = :category_id';
        $params[':category_id'] = $categoryId;
    }

    $where = $conditions ? 'WHERE ' . implode(' AND ', $conditions) : '';

    $stmt = $pdo->prepare(
        "SELECT n.id, n.title, n.content, n.created_at, n.updated_at,
                c.name AS category_name, c.id AS category_id
         FROM notes n
         JOIN categories c ON n.category_id = c.id
         {$where}
         ORDER BY n.updated_at DESC"
    );

    foreach ($params as $key => $value) {
        $stmt->bindValue($key, $value);
    }

    $stmt->execute();
    return $stmt->fetchAll();
}

function getAllCategories(): array
{
    global $pdo;
    $stmt = $pdo->query('SELECT id, name FROM categories ORDER BY name ASC');
    return $stmt->fetchAll();
}

function getNoteById(int $id): ?array
{
    global $pdo;
    $stmt = $pdo->prepare(
        'SELECT n.id, n.title, n.content, n.created_at, n.updated_at, c.name AS category_name, c.id AS category_id
         FROM notes n
         JOIN categories c ON n.category_id = c.id
         WHERE n.id = ? LIMIT 1'
    );
    $stmt->execute([$id]);
    $result = $stmt->fetch();
    return $result ?: null;
}

function createNote(string $title, string $content, int $categoryId): bool
{
    global $pdo;
    try {
        $stmt = $pdo->prepare(
            'INSERT INTO notes (title, content, category_id, created_at, updated_at)
             VALUES (?, ?, ?, NOW(), NOW())'
        );
        return $stmt->execute([$title, $content, $categoryId]);
    } catch (PDOException $e) {
        return false;
    }
}

function updateNote(int $id, string $title, string $content, int $categoryId): bool
{
    global $pdo;
    try {
        $stmt = $pdo->prepare(
            'UPDATE notes SET title = ?, content = ?, category_id = ?, updated_at = NOW()
             WHERE id = ?'
        );
        return $stmt->execute([$title, $content, $categoryId, $id]);
    } catch (PDOException $e) {
        return false;
    }
}

function deleteNote(int $id): bool
{
    global $pdo;
    try {
        $stmt = $pdo->prepare('DELETE FROM notes WHERE id = ?');
        return $stmt->execute([$id]);
    } catch (PDOException $e) {
        return false;
    }
}

function getCategoryById(int $id): ?array
{
    global $pdo;
    $stmt = $pdo->prepare(
        'SELECT c.id, c.name, c.created_at, COUNT(n.id) AS note_count
         FROM categories c
         LEFT JOIN notes n ON c.id = n.category_id
         WHERE c.id = ?
         GROUP BY c.id'
    );
    $stmt->execute([$id]);
    $result = $stmt->fetch();
    return $result ?: null;
}

function getCategoriesWithStats(): array
{
    global $pdo;
    $stmt = $pdo->query(
        'SELECT c.id, c.name, c.created_at, COUNT(n.id) AS note_count
         FROM categories c
         LEFT JOIN notes n ON c.id = n.category_id
         GROUP BY c.id
         ORDER BY c.name ASC'
    );
    return $stmt->fetchAll();
}

function createCategory(string $name): bool
{
    global $pdo;
    try {
        $stmt = $pdo->prepare(
            'INSERT INTO categories (name, created_at)
             VALUES (?, NOW())'
        );
        return $stmt->execute([$name]);
    } catch (PDOException $e) {
        return false;
    }
}

function updateCategory(int $id, string $name): bool
{
    global $pdo;
    try {
        $stmt = $pdo->prepare(
            'UPDATE categories SET name = ?
             WHERE id = ?'
        );
        return $stmt->execute([$name, $id]);
    } catch (PDOException $e) {
        return false;
    }
}

function deleteCategory(int $id): bool
{
    global $pdo;
    try {
        $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
        return $stmt->execute([$id]);
    } catch (PDOException $e) {
        return false;
    }
}
