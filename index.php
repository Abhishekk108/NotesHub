<?php
require_once __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';
?>

<section class="dashboard">
    <h2>Welcome to Noteshub</h2>
    <p>Manage your notes and categories in one place.</p>

    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Notes</h3>
            <p><?php echo number_format(getTotalNotes()); ?></p>
        </div>
        <div class="stat-card">
            <h3>Total Categories</h3>
            <p><?php echo number_format(getTotalCategories()); ?></p>
        </div>
    </div>

    <h3>Recent Notes</h3>
    <?php $recentNotes = getRecentNotes(5); ?>
    <?php if (empty($recentNotes)): ?>
        <p>No notes have been created yet.</p>
    <?php else: ?>
        <ul class="recent-notes">
            <?php foreach ($recentNotes as $note): ?>
                <li>
                    <strong><?php echo sanitize($note['title']); ?></strong>
                    <span class="meta"><?php echo sanitize($note['category_name']); ?> &middot; <?php echo sanitize(formatDate($note['created_at'])); ?></span>
                    <p><?php echo sanitize(truncateText($note['content'], 140)); ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>