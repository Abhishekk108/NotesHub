<?php
require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';

$errors   = [];
$formData = ['name' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';

    if (empty($name))               $errors['name'] = 'Category name is required.';
    elseif (mb_strlen($name) < 2)   $errors['name'] = 'Category name must be at least 2 characters long.';
    elseif (mb_strlen($name) > 100) $errors['name'] = 'Category name must not exceed 100 characters.';

    if (empty($errors)) {
        if (createCategory($name)) redirect(BASE_URL . 'categories/index.php');
        else $errors['db'] = 'Failed to create category. Please try again.';
    }

    $formData['name'] = $name;
}
?>

<div class="max-w-lg mx-auto">
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm">

        <div class="px-7 py-5 border-b border-slate-100">
            <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">Create a New Category</h2>
            <p class="text-slate-500 text-sm mt-0.5">Add a new category for organizing your notes</p>
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
                        Create Category
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
