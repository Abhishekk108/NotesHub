<?php
require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';

$errors = [];
$formData = ['name' => ''];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';

    // Validation
    if (empty($name)) {
        $errors['name'] = 'Category name is required.';
    } elseif (mb_strlen($name) < 2) {
        $errors['name'] = 'Category name must be at least 2 characters long.';
    } elseif (mb_strlen($name) > 100) {
        $errors['name'] = 'Category name must not exceed 100 characters.';
    }

    // If no errors, save the category
    if (empty($errors)) {
        if (createCategory($name)) {
            redirect(BASE_URL . 'categories/index.php');
        } else {
            $errors['db'] = 'Failed to create category. Please try again.';
        }
    }

    // Keep form data for display
    $formData['name'] = $name;
}
?>

<section class="form-section">
    <div class="form-header">
        <h2>Create a New Category</h2>
        <p>Add a new category for organizing your notes</p>
    </div>

    <?php if (!empty($errors) && isset($errors['db'])): ?>
        <div class="alert alert-danger">
            <?php echo sanitize($errors['db']); ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="form-container">
        <div class="form-group">
            <label for="name">Category Name *</label>
            <input
                type="text"
                id="name"
                name="name"
                value="<?php echo sanitize($formData['name']); ?>"
                placeholder="e.g., Work, Personal, Ideas"
                maxlength="100"
                class="form-input <?php echo !empty($errors['name']) ? 'input-error' : ''; ?>"
                required
            >
            <?php if (!empty($errors['name'])): ?>
                <span class="error-message"><?php echo sanitize($errors['name']); ?></span>
            <?php endif; ?>
            <small class="form-hint">2-100 characters. Make it descriptive.</small>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Create Category</button>
            <a href="<?php echo BASE_URL; ?>categories/index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>