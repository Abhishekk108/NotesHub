<?php
require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';

$noteId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($noteId === 0) { ?>
    <div class="min-h-96 flex items-center justify-center">
        <div class="bg-white border-t-4 border-red-500 rounded-2xl shadow-sm p-10 text-center max-w-md w-full">
            <div class="text-5xl mb-4">🚫</div>
            <h2 class="text-xl font-bold text-red-600 mb-2">Invalid Note ID</h2>
            <p class="text-slate-500 text-sm mb-6">The note you're looking for doesn't exist.</p>
            <a href="<?php echo BASE_URL; ?>notes/index.php"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                Back to Notes
            </a>
        </div>
    </div>
<?php
    include __DIR__ . '/../includes/footer.php'; exit;
}

$note = getNoteById($noteId);

if ($note === null) { ?>
    <div class="min-h-96 flex items-center justify-center">
        <div class="bg-white border-t-4 border-red-500 rounded-2xl shadow-sm p-10 text-center max-w-md w-full">
            <div class="text-2xl text-slate-400 mb-4"><i class="bi bi-search" aria-hidden="true"></i></div>
            <h2 class="text-xl font-bold text-red-600 mb-2">Note Not Found</h2>
            <p class="text-slate-500 text-sm mb-6">The note you're looking for has been deleted or doesn't exist.</p>
            <a href="<?php echo BASE_URL; ?>notes/index.php"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                Back to Notes
            </a>
        </div>
    </div>
<?php
    include __DIR__ . '/../includes/footer.php'; exit;
}
?>

<div class="bg-white border border-slate-200 rounded-2xl shadow-sm">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-5 p-6 border-b border-slate-100">
        <div class="flex-1">
            <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight mb-3">
                <?php echo sanitize($note['title']); ?>
            </h1>
            <div class="flex flex-wrap items-center gap-2 text-sm text-slate-500">
                <span class="inline-block bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                    <?php echo sanitize($note['category_name']); ?>
                </span>
                <span class="text-slate-300">•</span>
                <span>Created: <time class="font-medium text-slate-700"><?php echo formatDate($note['created_at'], 'M d, Y \a\t g:i A'); ?></time></span>
                <?php if ($note['updated_at'] !== $note['created_at']): ?>
                    <span class="text-slate-300">•</span>
                    <span>Updated: <time class="font-medium text-slate-700"><?php echo formatDate($note['updated_at'], 'M d, Y \a\t g:i A'); ?></time></span>
                <?php endif; ?>
            </div>
        </div>
        <div class="flex items-center gap-2 flex-shrink-0">
            <a href="<?php echo BASE_URL; ?>notes/edit.php?id=<?php echo $note['id']; ?>"
               class="inline-flex items-center gap-1.5 border border-amber-400 text-amber-600 hover:bg-amber-50 text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
                ✎ Edit
            </a>
            <a href="<?php echo BASE_URL; ?>notes/delete.php?id=<?php echo $note['id']; ?>"
               class="inline-flex items-center gap-1.5 border border-red-300 text-red-500 hover:bg-red-50 text-sm font-semibold px-4 py-2 rounded-lg transition-colors"
               onclick="return confirm('Are you sure you want to delete this note?');">
                🗑 Delete
            </a>
        </div>
    </div>

    <!-- Content -->
    <div class="p-6">
        <div class="note-content text-slate-700 leading-relaxed text-base">
            <?php echo nl2br(sanitize($note['content'])); ?>
        </div>
    </div>

    <!-- Footer -->
    <div class="px-6 py-4 border-t border-slate-100">
        <a href="<?php echo BASE_URL; ?>notes/index.php"
           class="inline-flex items-center gap-2 border border-slate-200 hover:border-slate-300 text-slate-600 text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
            ← Back to Notes
        </a>
    </div>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
