<?php
require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';

$noteId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($noteId === 0) { ?>
    <div class="min-h-96 flex items-center justify-center">
        <div class="bg-white border-t-4 border-red-500 rounded-2xl shadow-sm p-10 text-center max-w-md w-full">
            <div class="text-5xl mb-4">🚫</div>
            <h2 class="text-xl font-bold text-red-600 mb-2">Invalid Note ID</h2>
            <p class="text-slate-500 text-sm mb-6">The note you're trying to delete doesn't exist.</p>
            <a href="<?php echo BASE_URL; ?>notes/index.php"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                Back to Notes
            </a>
        </div>
    </div>
<?php include __DIR__ . '/../includes/footer.php'; exit; }

$note = getNoteById($noteId);

if ($note === null) { ?>
    <div class="min-h-96 flex items-center justify-center">
        <div class="bg-white border-t-4 border-red-500 rounded-2xl shadow-sm p-10 text-center max-w-md w-full">
            <div class="text-2xl text-slate-400 mb-4"><i class="bi bi-search" aria-hidden="true"></i></div>
            <h2 class="text-xl font-bold text-red-600 mb-2">Note Not Found</h2>
            <p class="text-slate-500 text-sm mb-6">The note you're trying to delete has already been removed or doesn't exist.</p>
            <a href="<?php echo BASE_URL; ?>notes/index.php"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                Back to Notes
            </a>
        </div>
    </div>
<?php include __DIR__ . '/../includes/footer.php'; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    if (deleteNote($noteId)) redirect(BASE_URL . 'notes/index.php');
    else $deleteError = 'Failed to delete the note. Please try again.';
}
?>

<div class="min-h-96 flex items-center justify-center py-8">
    <div class="bg-white border-t-4 border-red-500 rounded-2xl shadow-sm p-8 max-w-md w-full text-center">

        <div class="text-5xl mb-3">⚠️</div>
        <h2 class="text-xl font-bold text-red-600 mb-2">Delete Note?</h2>
        <p class="text-slate-500 text-sm mb-5">You're about to permanently delete the following note:</p>

        <!-- Preview box -->
        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 mb-5 text-left">
            <h3 class="text-sm font-bold text-slate-800 mb-2"><?php echo sanitize($note['title']); ?></h3>
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-block bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                    <?php echo sanitize($note['category_name']); ?>
                </span>
                <span class="text-xs text-slate-400"><?php echo formatDate($note['updated_at'], 'M d, Y'); ?></span>
            </div>
            <p class="text-xs text-slate-500 leading-relaxed"><?php echo sanitize(truncateText($note['content'], 200)); ?></p>
        </div>

        <?php if (isset($deleteError)): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 mb-4 text-left">
                ⚠️ <?php echo sanitize($deleteError); ?>
            </div>
        <?php endif; ?>

        <p class="text-xs font-semibold text-red-500 mb-5">This action cannot be undone.</p>

        <form method="POST" class="flex flex-col gap-3">
            <button type="submit" name="confirm_delete" value="1"
                    class="w-full bg-red-600 hover:bg-red-700 text-white text-sm font-semibold py-2.5 rounded-lg transition-colors">
                🗑 Yes, Delete This Note
            </button>
            <a href="<?php echo BASE_URL; ?>notes/view.php?id=<?php echo $noteId; ?>"
               class="w-full border border-slate-200 hover:border-slate-300 text-slate-600 text-sm font-semibold py-2.5 rounded-lg transition-colors">
                Cancel
            </a>
        </form>

    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
