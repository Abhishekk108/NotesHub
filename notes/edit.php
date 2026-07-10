<?php
require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';

// Get note ID from URL
$noteId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Validate note ID and fetch the note
if ($noteId === 0) {
    ?>
    <section class="error-section">
        <div class="error-container">
            <h2>Invalid Note ID</h2>
            <p>The note you're looking for doesn't exist.</p>
            <a href="<?php echo BASE_URL; ?>notes/index.php" class="btn btn-primary">Back to Notes</a>
        </div>
    </section>
    <?php
    include __DIR__ . '/../includes/footer.php';
    exit;
}

$note = getNoteById($noteId);

if ($note === null) {
    ?>
    <section class="error-section">
        <div class="error-container">
            <h2>Note Not Found</h2>
            <p>The note you're looking for has been deleted or doesn't exist.</p>
            <a href="<?php echo BASE_URL; ?>notes/index.php" class="btn btn-primary">Back to Notes</a>
        </div>
    </section>
    <?php
    include __DIR__ . '/../includes/footer.php';
    exit;
}

$errors = [];
$formData = [
    'title' => $note['title'],
    'content' => $note['content'],
    'category_id' => $note['category_id']
];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = isset($_POST['title']) ? trim($_POST['title']) : '';
    $content = isset($_POST['content']) ? trim($_POST['content']) : '';
    $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;

    // Validation
    if (empty($title)) {
        $errors['title'] = 'Note title is required.';
    } elseif (mb_strlen($title) > 255) {
        $errors['title'] = 'Title must be less than 255 characters.';
    }

    if (empty($content)) {
        $errors['content'] = 'Note content is required.';
    } elseif (mb_strlen($content) < 10) {
        $errors['content'] = 'Content must be at least 10 characters long.';
    }

    if ($category_id === 0 || !categoryExists($category_id)) {
        $errors['category_id'] = 'Please select a valid category.';
    }

    // If no errors, update the note
    if (empty($errors)) {
        if (updateNote($noteId, $title, $content, $category_id)) {
            redirect(BASE_URL . 'notes/view.php?id=' . $noteId);
        } else {
            $errors['db'] = 'Failed to update note. Please try again.';
        }
    }

    // Keep form data for display
    $formData['title'] = $title;
    $formData['content'] = $content;
    $formData['category_id'] = $category_id;
}

$categories = getAllCategories();
?>

<section class="form-section">
    <div class="form-header">
        <h2>Edit Note</h2>
        <p>Update your note details</p>
    </div>

    <?php if (!empty($errors) && isset($errors['db'])): ?>
        <div class="alert alert-danger">
            <?php echo sanitize($errors['db']); ?>
        </div>
    <?php endif; ?>

    <?php if (empty($categories)): ?>
        <div class="alert alert-warning">
            ⚠️ No categories available. <a href="<?php echo BASE_URL; ?>categories/create.php">Create a category first</a>.
        </div>
    <?php else: ?>
        <form method="POST" class="form-container">
            <div class="form-group">
                <label for="title">Note Title *</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="<?php echo sanitize($formData['title']); ?>"
                    placeholder="Enter a descriptive title for your note"
                    maxlength="255"
                    class="form-input <?php echo !empty($errors['title']) ? 'input-error' : ''; ?>"
                    required
                >
                <?php if (!empty($errors['title'])): ?>
                    <span class="error-message"><?php echo sanitize($errors['title']); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="category_id">Category *</label>
                <select
                    id="category_id"
                    name="category_id"
                    class="form-input <?php echo !empty($errors['category_id']) ? 'input-error' : ''; ?>"
                    required
                >
                    <option value="">-- Select a Category --</option>
                    <?php foreach ($categories as $category): ?>
                        <option
                            value="<?php echo $category['id']; ?>"
                            <?php echo $formData['category_id'] === (int)$category['id'] ? 'selected' : ''; ?>
                        >
                            <?php echo sanitize($category['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if (!empty($errors['category_id'])): ?>
                    <span class="error-message"><?php echo sanitize($errors['category_id']); ?></span>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label for="content">Note Content *</label>
                <textarea
                    id="content"
                    name="content"
                    placeholder="Write your note here... (minimum 10 characters)"
                    rows="10"
                    class="form-input form-textarea <?php echo !empty($errors['content']) ? 'input-error' : ''; ?>"
                    required
                ><?php echo sanitize($formData['content']); ?></textarea>
                <?php if (!empty($errors['content'])): ?>
                    <span class="error-message"><?php echo sanitize($errors['content']); ?></span>
                <?php endif; ?>
                <small class="form-hint">Minimum 10 characters</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Note</button>
                <a href="<?php echo BASE_URL; ?>notes/view.php?id=<?php echo $noteId; ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>