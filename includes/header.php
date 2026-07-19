<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(APP_NAME); ?></title>
    <!-- Inter font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Stylesheets -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/base.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/layout.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/components.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/dashboard.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/notes.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/forms.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/categories.css">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="header-logo" aria-hidden="true">📓</div>
            <h1><?php echo htmlspecialchars(APP_NAME); ?></h1>
        </div>
    </header>
    <?php include_once __DIR__ . '/navbar.php'; ?>
    <main class="container">
