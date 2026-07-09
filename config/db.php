<?php
// config/db.php
// PDO database connection for local development (XAMPP)

$host = 'localhost';
$db   = 'noteshub';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsnRoot = "mysql:host=$host;charset=$charset";
$dsnWithDb = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    // Connect to server first (without selecting a DB) so we can create the DB if it doesn't exist.
    $pdo = new PDO($dsnRoot, $user, $pass, $options);

    // Create database if it doesn't exist (safe for local dev)
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET $charset COLLATE ${charset}_unicode_ci");

    // Select the database
    $pdo->exec("USE `$db`");

    // Recreate PDO instance bound to the target database for clarity
    $pdo = new PDO($dsnWithDb, $user, $pass, $options);

} catch (PDOException $e) {
    if (php_sapi_name() === 'cli') {
        fwrite(STDERR, "Database connection failed: " . $e->getMessage() . "\n");
    } else {
        echo '<p><strong>Database connection failed:</strong> ' . htmlspecialchars($e->getMessage()) . '</p>';
    }
    exit(1);
}

// Export $pdo for use by other scripts
return;

?>
