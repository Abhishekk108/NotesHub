<?php
require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';

$categoryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($categoryId === 0) { ?>
    <div class="min-h-96 flex items-center justify-center">
        <div class="bg-white border-t-4 border-red-500 rounded-2xl shadow-sm p-10 text-center max-w-md w-full">
            <div class="text-5xl mb-4">🚫</div>
            <h2 class="text-xl font-bold text-red-600 mb-2">Invalid Category ID</h2>
            <p class="text-slate-500 text-sm mb-6">The category you're trying to delete doesn't exist.</p>
            <a href="<?php echo BASE_URL; ?>categories/index.php"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                Back to Categories
            </a>
        </div>
    </div>
<?php include __DIR__ . '/../includes/footer.php'; exit; }

$category = getCategoryById($categoryId);

if ($category === null) { ?>
    <div class="min-h-96 flex items-center justify-center">
        <div class="bg-white border-t-4 border-red-500 rounded-2xl shadow-sm p-10 text-center max-w-md w-full">
            <div class="text-5xl mb-4">🔍</div>
            <h2 class="text-xl font-bold text-red-600 mb-2">Category Not Found</h2>
            <p class="text-slate-500 text-sm mb-6">The category you're trying to delete has already been removed or doesn't exist.</p>
            <a href="<?php echo BASE_URL; ?>categories/index.php"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                Back to Categories
            </a>
        </div>
    </div>
<?php include __DIR__ . '/../includes/footer.php'; exit; }

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    if (deleteCategory($categoryId)) redirect(BASE_URL . 'categories/index.php');
    else $deleteError = 'Failed to delete the category. Please try again.';
}
?>

<div class="min-h-96 flex items-center justify-center py-8">
    <div class="bg-white border-t-4 border-red-500 rounded-2xl shadow-sm p-8 max-w-md w-full text-center">

        <div class="text-5xl mb-3">⚠️</div>
        <h2 class="text-xl font-bold text-red-600 mb-2">Delete Category?</h2>
        <p class="text-slate-500 text-sm mb-5">You're about to permanently delete the following category:</p>

        <!-- Preview box -->
        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 mb-5 text-left">
            <h3 class="text-sm font-bold text-slate-800 mb-2"><?php echo sanitize($category['name']); ?></h3>
            <div class="flex items-center gap-3 text-xs text-slate-500">
                <span class="font-semibold text-blue-600">
                    <?php echo $category['note_count']; ?> <?php echo $category['note_count'] == 1 ? 'note' : 'notes'; ?>
                </span>
                <span>Created: <?php echo formatDate($category['created_at'], 'M d, Y'); ?></span>
            </div>
        </div>

        <?php if ((int)$category['note_count'] > 0): ?>
            <div class="bg-amber-50 border border-amber-200 text-amber-800 text-sm rounded-xl px-4 py-3 mb-4 text-left">
                ⚠️ This category contains <strong><?php echo $category['note_count']; ?></strong>
                <?php echo $category['note_count'] == 1 ? 'note' : 'notes'; ?>.
                Deleting it will also permanently delete all associated notes.
            </div>
        <?php endif; ?>

        <?php if (isset($deleteError)): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 mb-4 text-left">
                ⚠️ <?php echo sanitize($deleteError); ?>
            </div>
        <?php endif; ?>

        <p class="text-xs font-semibold text-red-500 mb-5">This action cannot be undone.</p>

        <form method="POST" class="flex flex-col gap-3">
            <button type="submit" name="confirm_delete" value="1"
                    class="w-full bg-red-600 hover:bg-red-700 text-white text-sm font-semibold py-2.5 rounded-lg transition-colors">
                🗑 Yes, Delete This Category
            </button>
            <a href="<?php echo BASE_URL; ?>categories/index.php"
               class="w-full border border-slate-200 hover:border-slate-300 text-slate-600 text-sm font-semibold py-2.5 rounded-lg transition-colors">
                Cancel
            </a>
        </form>

    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
