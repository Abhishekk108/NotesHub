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
            <p>The note you're trying to delete doesn't exist.</p>
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
            <p>The note you're trying to delete has already been removed or doesn't exist.</p>
            <a href="<?php echo BASE_URL; ?>notes/index.php" class="btn btn-primary">Back to Notes</a>
        </div>
    </section>
    <?php
    include __DIR__ . '/../includes/footer.php';
    exit;
}

// Handle deletion confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    if (deleteNote($noteId)) {
        redirect(BASE_URL . 'notes/index.php');
    } else {
        $deleteError = 'Failed to delete the note. Please try again.';
    }
}
?>

<section class="delete-confirmation-section">
    <div class="confirmation-container">
        <div class="confirmation-icon">⚠️</div>
        <h2>Delete Note?</h2>
        <p class="confirmation-message">
            You're about to permanently delete the following note:
        </p>

        <div class="note-preview-box">
            <h3><?php echo sanitize($note['title']); ?></h3>
            <div class="preview-meta">
                <span class="category-badge"><?php echo sanitize($note['category_name']); ?></span>
                <span class="preview-date"><?php echo formatDate($note['updated_at'], 'M d, Y'); ?></span>
            </div>
            <p><?php echo sanitize(truncateText($note['content'], 200)); ?></p>
        </div>

        <?php if (isset($deleteError)): ?>
            <div class="alert alert-danger" style="margin-bottom: 1.5rem;">
                <?php echo sanitize($deleteError); ?>
            </div>
        <?php endif; ?>

        <p class="warning-text">
            This action cannot be undone. Please make sure you want to delete this note.
        </p>

        <form method="POST" class="confirmation-actions">
            <button type="submit" name="confirm_delete" value="1" class="btn btn-danger">
                🗑 Yes, Delete This Note
            </button>
            <a href="<?php echo BASE_URL; ?>notes/view.php?id=<?php echo $noteId; ?>" class="btn btn-secondary">
                Cancel
            </a>
        </form>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>