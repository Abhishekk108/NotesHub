<?php
require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';

$notes = getAllNotes();
?>

<section class="notes-section">
    <div class="page-header">
        <div>
            <h2>All Notes</h2>
            <p>Manage and organize your notes</p>
        </div>
        <a href="<?php echo BASE_URL; ?>notes/create.php" class="btn btn-primary">+ Create Note</a>
    </div>

    <?php if (empty($notes)): ?>
        <div class="empty-state">
            <div class="empty-icon">📝</div>
            <h3>No notes yet</h3>
            <p>Start by creating your first note.</p>
            <a href="<?php echo BASE_URL; ?>notes/create.php" class="btn btn-primary">Create Your First Note</a>
        </div>
    <?php else: ?>
        <div class="notes-grid">
            <?php foreach ($notes as $note): ?>
                <div class="note-card">
                    <div class="card-header">
                        <h3><a href="<?php echo BASE_URL; ?>notes/view.php?id=<?php echo $note['id']; ?>"><?php echo sanitize($note['title']); ?></a></h3>
                        <span class="category-badge"><?php echo sanitize($note['category_name']); ?></span>
                    </div>

                    <div class="card-dates">
                        <span class="date-label">Updated:</span>
                        <span class="date-value"><?php echo formatDate($note['updated_at'], 'M d, Y'); ?></span>
                    </div>

                    <p class="card-preview"><?php echo sanitize(truncateText($note['content'], 150)); ?></p>

                    <div class="card-actions">
                        <a href="<?php echo BASE_URL; ?>notes/view.php?id=<?php echo $note['id']; ?>" class="action-btn action-view" title="View note">View</a>
                        <a href="<?php echo BASE_URL; ?>notes/edit.php?id=<?php echo $note['id']; ?>" class="action-btn action-edit" title="Edit note">Edit</a>
                        <a href="<?php echo BASE_URL; ?>notes/delete.php?id=<?php echo $note['id']; ?>" class="action-btn action-delete" title="Delete note" onclick="return confirm('Are you sure you want to delete this note?');">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>