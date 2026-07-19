<?php
require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';

// Get category ID from URL
$categoryId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Validate category ID and fetch the category
if ($categoryId === 0) {
    ?>
    <section class="error-section">
        <div class="error-container">
            <h2>Invalid Category ID</h2>
            <p>The category you're trying to delete doesn't exist.</p>
            <a href="<?php echo BASE_URL; ?>categories/index.php" class="btn btn-primary">Back to Categories</a>
        </div>
    </section>
    <?php
    include __DIR__ . '/../includes/footer.php';
    exit;
}

$category = getCategoryById($categoryId);

if ($category === null) {
    ?>
    <section class="error-section">
        <div class="error-container">
            <h2>Category Not Found</h2>
            <p>The category you're trying to delete has already been removed or doesn't exist.</p>
            <a href="<?php echo BASE_URL; ?>categories/index.php" class="btn btn-primary">Back to Categories</a>
        </div>
    </section>
    <?php
    include __DIR__ . '/../includes/footer.php';
    exit;
}

// Handle deletion confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    if (deleteCategory($categoryId)) {
        redirect(BASE_URL . 'categories/index.php');
    } else {
        $deleteError = 'Failed to delete the category. Please try again.';
    }
}
?>

<section class="delete-confirmation-section">
    <div class="confirmation-container">
        <div class="confirmation-icon">⚠️</div>
        <h2>Delete Category?</h2>
        <p class="confirmation-message">
            You're about to permanently delete the following category:
        </p>

        <div class="note-preview-box">
            <h3><?php echo sanitize($category['name']); ?></h3>
            <div class="preview-meta">
                <span class="card-stats">
                    <?php echo $category['note_count']; ?> <?php echo $category['note_count'] == 1 ? 'note' : 'notes'; ?>
                </span>
                <span class="preview-date">Created: <?php echo formatDate($category['created_at'], 'M d, Y'); ?></span>
            </div>
        </div>

        <?php if ((int)$category['note_count'] > 0): ?>
            <div class="alert alert-warning">
                ⚠️ This category contains <strong><?php echo $category['note_count']; ?></strong>
                <?php echo $category['note_count'] == 1 ? 'note' : 'notes'; ?>.
                Deleting it will also permanently delete all associated notes.
            </div>
        <?php endif; ?>

        <?php if (isset($deleteError)): ?>
            <div class="alert alert-danger">
                <?php echo sanitize($deleteError); ?>
            </div>
        <?php endif; ?>

        <p class="warning-text">
            This action cannot be undone. Please make sure you want to delete this category.
        </p>

        <form method="POST" class="confirmation-actions">
            <button type="submit" name="confirm_delete" value="1" class="btn btn-danger">
                🗑 Yes, Delete This Category
            </button>
            <a href="<?php echo BASE_URL; ?>categories/index.php" class="btn btn-secondary">
                Cancel
            </a>
        </form>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
