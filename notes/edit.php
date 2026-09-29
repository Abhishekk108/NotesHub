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
<?php include __DIR__ . '/../includes/footer.php'; exit; }

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
<?php include __DIR__ . '/../includes/footer.php'; exit; }

$errors   = [];
$formData = ['title' => $note['title'], 'content' => $note['content'], 'category_id' => $note['category_id']];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = isset($_POST['title'])       ? trim($_POST['title'])       : '';
    $content     = isset($_POST['content'])     ? trim($_POST['content'])     : '';
    $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;

    if (empty($title))                $errors['title']       = 'Note title is required.';
    elseif (mb_strlen($title) > 255)  $errors['title']       = 'Title must be less than 255 characters.';
    if (empty($content))              $errors['content']     = 'Note content is required.';
    elseif (mb_strlen($content) < 10) $errors['content']     = 'Content must be at least 10 characters long.';
    if ($category_id === 0 || !categoryExists($category_id)) $errors['category_id'] = 'Please select a valid category.';

    if (empty($errors)) {
        if (updateNote($noteId, $title, $content, $category_id)) redirect(BASE_URL . 'notes/view.php?id=' . $noteId);
        else $errors['db'] = 'Failed to update note. Please try again.';
    }

    $formData = ['title' => $title, 'content' => $content, 'category_id' => $category_id];
}

$categories = getAllCategories();
?>

<div class="max-w-2xl mx-auto">
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm">

        <div class="px-7 py-5 border-b border-slate-100">
            <h2 class="text-xl font-extrabold text-slate-800 tracking-tight">Edit Note</h2>
            <p class="text-slate-500 text-sm mt-0.5">Update your note details</p>
        </div>

        <div class="px-7 py-6">

            <?php if (!empty($errors['db'])): ?>
                <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3 mb-5">
                    ⚠️ <?php echo sanitize($errors['db']); ?>
                </div>
            <?php endif; ?>

            <?php if (empty($categories)): ?>
                <div class="flex items-start gap-3 bg-amber-50 border border-amber-200 text-amber-800 text-sm rounded-xl px-4 py-3">
                    ⚠️ No categories available.
                    <a href="<?php echo BASE_URL; ?>categories/create.php" class="font-semibold underline hover:no-underline">Create a category first</a>.
                </div>
            <?php else: ?>
                <form method="POST" class="flex flex-col gap-5">

                    <div class="flex flex-col gap-1.5">
                        <label for="title" class="text-sm font-semibold text-slate-700">Note Title <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title"
                               value="<?php echo sanitize($formData['title']); ?>"
                               placeholder="Enter a descriptive title for your note"
                               maxlength="255"
                               class="w-full px-3.5 py-2.5 text-sm border rounded-lg bg-slate-50 text-slate-800 placeholder-slate-400 outline-none transition
                                      <?php echo !empty($errors['title']) ? 'border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100'; ?>"
                               required>
                        <?php if (!empty($errors['title'])): ?>
                            <p class="text-xs text-red-500 font-medium"><?php echo sanitize($errors['title']); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="category_id" class="text-sm font-semibold text-slate-700">Category <span class="text-red-500">*</span></label>
                        <select id="category_id" name="category_id"
                                class="w-full px-3.5 py-2.5 text-sm border rounded-lg bg-slate-50 text-slate-800 outline-none transition cursor-pointer
                                       <?php echo !empty($errors['category_id']) ? 'border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100'; ?>"
                                required>
                            <option value="">-- Select a Category --</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo $category['id']; ?>"
                                    <?php echo $formData['category_id'] === (int)$category['id'] ? 'selected' : ''; ?>>
                                    <?php echo sanitize($category['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <?php if (!empty($errors['category_id'])): ?>
                            <p class="text-xs text-red-500 font-medium"><?php echo sanitize($errors['category_id']); ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="flex flex-col gap-1.5">
                        <label for="content" class="text-sm font-semibold text-slate-700">Note Content <span class="text-red-500">*</span></label>
                        <textarea id="content" name="content" rows="10"
                                  placeholder="Write your note here… (minimum 10 characters)"
                                  class="w-full px-3.5 py-2.5 text-sm border rounded-lg bg-slate-50 text-slate-800 placeholder-slate-400 outline-none transition resize-y
                                         <?php echo !empty($errors['content']) ? 'border-red-400 focus:ring-2 focus:ring-red-100' : 'border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100'; ?>"
                                  required><?php echo sanitize($formData['content']); ?></textarea>
                        <?php if (!empty($errors['content'])): ?>
                            <p class="text-xs text-red-500 font-medium"><?php echo sanitize($errors['content']); ?></p>
                        <?php endif; ?>
                        <p class="text-xs text-slate-400">Minimum 10 characters</p>
                    </div>

                    <div class="flex gap-3 pt-2 border-t border-slate-100">
                        <button type="submit"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold py-2.5 px-5 rounded-lg transition-colors">
                            Update Note
                        </button>
                        <a href="<?php echo BASE_URL; ?>notes/view.php?id=<?php echo $noteId; ?>"
                           class="flex-1 text-center border border-slate-200 hover:border-slate-300 text-slate-600 text-sm font-semibold py-2.5 px-5 rounded-lg transition-colors">
                            Cancel
                        </a>
                    </div>

                </form>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
