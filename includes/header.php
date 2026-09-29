<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars(APP_NAME); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/styles.css">
    <style>
        .note-content { white-space: pre-wrap; word-wrap: break-word; }
        #navMenu { display: flex; }
        @media (max-width: 768px) {
            #navMenu { display: none; }
            #navMenu.open { display: flex; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-700 font-sans min-h-screen flex flex-col app-body">

    <?php include_once __DIR__ . '/navbar.php'; ?>

    <main class="app-main">
