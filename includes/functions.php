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
