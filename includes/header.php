<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(APP_NAME); ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <h1><?php echo htmlspecialchars(APP_NAME); ?></h1>
        </div>
    </header>
    <?php include_once __DIR__ . '/navbar.php'; ?>
    <main class="container">
