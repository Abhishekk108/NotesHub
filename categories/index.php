<?php
require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';

$categories = getCategoriesWithStats();
?>

<!-- Page header -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-5 border-b border-slate-200">
    <div>
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Categories</h2>
        <p class="text-slate-500 text-sm mt-0.5">Manage your note categories</p>
    </div>
    <a href="<?php echo BASE_URL; ?>categories/create.php"
       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-colors shadow-sm whitespace-nowrap">
        + New Category
    </a>
</div>

<?php if (empty($categories)): ?>
    <div class="bg-white border-2 border-dashed border-slate-200 rounded-2xl text-center py-16 px-6">
        <div class="text-5xl mb-4">📂</div>
        <h3 class="text-lg font-bold text-slate-700 mb-1">No categories yet</h3>
        <p class="text-slate-500 text-sm mb-5">Start by creating your first category.</p>
        <a href="<?php echo BASE_URL; ?>categories/create.php"
           class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
            Create Your First Category
        </a>
    </div>

<?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php foreach ($categories as $category): ?>
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-col hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">

                <div class="p-5 flex-1">
                    <div class="text-3xl mb-3">📁</div>
                    <h3 class="text-base font-bold text-slate-800 mb-1 break-words"><?php echo sanitize($category['name']); ?></h3>
                    <p class="text-sm font-semibold text-blue-600 mb-1">
                        <?php echo $category['note_count']; ?> <?php echo $category['note_count'] === 1 ? 'note' : 'notes'; ?>
                    </p>
                    <p class="text-xs text-slate-400">Created: <?php echo formatDate($category['created_at'], 'M d, Y'); ?></p>
                </div>

                <div class="flex border-t border-slate-100">
                    <a href="<?php echo BASE_URL; ?>categories/edit.php?id=<?php echo $category['id']; ?>"
                       class="flex-1 text-center text-xs font-semibold text-amber-600 hover:bg-amber-50 py-2.5 transition-colors rounded-bl-2xl">
                        Edit
                    </a>
                    <a href="<?php echo BASE_URL; ?>categories/delete.php?id=<?php echo $category['id']; ?>"
                       class="flex-1 text-center text-xs font-semibold text-red-500 hover:bg-red-50 py-2.5 border-l border-slate-100 transition-colors rounded-br-2xl"
                       onclick="return confirm('Are you sure you want to delete this category and all its notes?');">
                        Delete
                    </a>
                </div>

            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
