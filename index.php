<?php
require_once __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';
?>

<section class="dashboard">
    <div class="dashboard-header">
        <h2>Welcome to Noteshub</h2>
        <p>Manage your notes and categories in one place.</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon-wrap">📝</div>
            <div class="stat-body">
                <h3>Total Notes</h3>
                <p class="stat-number"><?php echo number_format(getTotalNotes()); ?></p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon-wrap">📂</div>
            <div class="stat-body">
                <h3>Total Categories</h3>
                <p class="stat-number"><?php echo number_format(getTotalCategories()); ?></p>
            </div>
        </div>
    </div>

    <div class="recent-section">
        <div class="section-header">
            <h3>Recently Updated Notes</h3>
            <a href="<?php echo BASE_URL; ?>notes/index.php" class="view-all">View All →</a>
        </div>

        <?php $recentNotes = getRecentNotes(5); ?>
        <?php if (empty($recentNotes)): ?>
            <div class="empty-state">
                <span class="empty-icon">📝</span>
                <h3>No notes yet</h3>
                <p>Create your first note to get started.</p>
                <a href="<?php echo BASE_URL; ?>notes/create.php" class="btn btn-primary">Create Your First Note</a>
            </div>
        <?php else: ?>
            <div class="recent-notes">
                <?php foreach ($recentNotes as $note): ?>
                    <div class="note-item">
                        <div class="note-header">
                            <h4><a href="<?php echo BASE_URL; ?>notes/view.php?id=<?php echo $note['id']; ?>"><?php echo sanitize($note['title']); ?></a></h4>
                            <span class="note-date"><?php echo formatDate($note['updated_at'], 'M d, Y'); ?></span>
                        </div>
                        <div class="note-meta">
                            <span class="category-badge"><?php echo sanitize($note['category_name']); ?></span>
                        </div>
                        <p class="note-preview"><?php echo sanitize(truncateText($note['content'], 150)); ?></p>
                        <div class="note-actions">
                            <a href="<?php echo BASE_URL; ?>notes/view.php?id=<?php echo $note['id']; ?>" class="link-btn">Read</a>
                            <a href="<?php echo BASE_URL; ?>notes/edit.php?id=<?php echo $note['id']; ?>" class="link-btn">Edit</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>