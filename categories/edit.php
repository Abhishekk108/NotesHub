<?php
require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';

$categoryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($categoryId === 0) { ?>
    <div class="min-h-96 flex items-center justify-center">
        <div class="bg-white border-t-4 border-red-500 rounded-2xl shadow-sm p-10 text-center max-w-md w-full">
            <div class="text-5xl mb-4">🚫</div>
            <h2 class="text-xl font-bold text-red-600 mb-2">Invalid Category ID</h2>
            <p class="text-slate-500 text-sm mb-6">The category you're looking for doesn't exist.</p>
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
            <div class="text-2xl text-slate-400 mb-4"><i class="bi bi-search" aria-hidden="true"></i></div>
            <h2 class="text-xl font-bold text-red-600 mb-2">Category Not Found</h2>
            <p class="text-slate-500 text-sm mb-6">The category you're looking for has been deleted or doesn't exist.</p>
            <a href="<?php echo BASE_URL; ?>categories/index.php"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                Back to Categories
            </a>
        </div>
    </div>
<?php include __DIR__ . '/../includes/footer.php'; exit; }

$errors   = [];
$formData = ['name' => $category['name']];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';

    if (empty($name))               $errors['name'] = 'Category name is required.';
    elseif (mb_strlen($name) < 2)   $errors['name'] = 'Category name must be at least 2 characters long.';
    elseif (mb_strlen($name) > 100) $errors['name'] = 'Category name must not exceed 100 characters.';

    if (empty($errors)) {
        if (updateCategory($categoryId, $name)) redirect(BASE_URL . 'categories/index.php');
        else $errors['db'] = 'Failed to update category. Please try again.';
    }

    $formData['name'] = $name;
}
?>

<div class="max-w-lg mx-auto">
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm">

        <div class="px-7 py-5 border-b border-slate-100">
            <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">Edit Category</h2>
            <p class="text-slate-500 text-sm mt-0.5">Update the category name</p>
        </div>

        <div class="px-7 py-6">

            <?php if (!empty($errors['db'])): ?>
                <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 mb-5">
                    ⚠️ <?php echo sanitize($errors['db']); ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="flex flex-col gap-5">

                <div class="flex flex-col gap-1.5">
                    <label for="name" class="text-sm font-semibold text-slate-700">Category Name <span class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name"
                           value="<?php echo sanitize($formData['name']); ?>"
                           placeholder="e.g., Work, Personal, Ideas"
                           maxlength="100"
                           class="w-full px-3.5 py-2.5 text-sm border rounded-lg bg-slate-50 text-slate-800 placeholder-slate-400 outline-none transition
                                  <?php echo !empty($errors['name']) ? 'border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100'; ?>"
                           required>
                    <?php if (!empty($errors['name'])): ?>
                        <p class="text-xs text-red-500 font-medium"><?php echo sanitize($errors['name']); ?></p>
                    <?php endif; ?>
                    <p class="text-xs text-slate-400">2–100 characters. Make it descriptive.</p>
                </div>

                <div class="flex gap-3 pt-2 border-t border-slate-100">
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 px-5 rounded-lg transition-colors">
                        Update Category
                    </button>
                    <a href="<?php echo BASE_URL; ?>categories/index.php"
                       class="flex-1 text-center border border-slate-200 hover:border-slate-300 text-slate-600 text-sm font-semibold py-2.5 px-5 rounded-lg transition-colors">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
