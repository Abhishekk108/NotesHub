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
?>

<section class="note-view-section">
    <div class="view-header">
        <div class="view-title-area">
            <h1><?php echo sanitize($note['title']); ?></h1>
            <div class="view-meta">
                <span class="category-badge-large"><?php echo sanitize($note['category_name']); ?></span>
                <span class="meta-separator">•</span>
                <span class="timestamp">
                    Created: <time><?php echo formatDate($note['created_at'], 'M d, Y \a\t g:i A'); ?></time>
                </span>
                <?php if ($note['updated_at'] !== $note['created_at']): ?>
                    <span class="meta-separator">•</span>
                    <span class="timestamp">
                        Updated: <time><?php echo formatDate($note['updated_at'], 'M d, Y \a\t g:i A'); ?></time>
                    </span>
                <?php endif; ?>
            </div>
        </div>
        <div class="view-actions">
            <a href="<?php echo BASE_URL; ?>notes/edit.php?id=<?php echo $note['id']; ?>" class="action-btn action-btn-edit">✎ Edit</a>
            <a href="<?php echo BASE_URL; ?>notes/delete.php?id=<?php echo $note['id']; ?>" class="action-btn action-btn-delete" onclick="return confirm('Are you sure you want to delete this note?');">🗑 Delete</a>
        </div>
    </div>

    <div class="view-content-area">
        <div class="note-content">
            <?php echo nl2br(sanitize($note['content'])); ?>
        </div>
    </div>

    <div class="view-footer">
        <a href="<?php echo BASE_URL; ?>notes/index.php" class="btn btn-secondary">← Back to Notes</a>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>