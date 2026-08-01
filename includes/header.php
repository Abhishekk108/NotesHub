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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* Only things Tailwind utilities can't express inline */
        .note-content { white-space: pre-wrap; word-wrap: break-word; }
        #navMenu { display: flex; }
        @media (max-width: 768px) {
            #navMenu { display: none; }
            #navMenu.open { display: flex; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-700 font-sans min-h-screen flex flex-col">

    <header class="bg-gradient-to-r from-blue-600 to-violet-600 text-white shadow-md">
        <div class="max-w-6xl mx-auto px-6 py-4 flex items-center gap-3">
            <div class="w-9 h-9 bg-white/20 rounded-lg flex items-center justify-center text-lg backdrop-blur-sm" aria-hidden="true">📓</div>
            <h1 class="text-2xl font-extrabold tracking-tight"><?php echo htmlspecialchars(APP_NAME); ?></h1>
        </div>
    </header>

    <?php include_once __DIR__ . '/navbar.php'; ?>

    <main class="max-w-6xl mx-auto px-6 py-8 w-full flex-1">
