<?php
require_once __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';
?>

<div class="dashboard">
    <div class="dashboard-heading">
        <h2>Dashboard</h2>
        <p>Manage your notes and categories in one place.</p>
    </div>

    <div class="dashboard-stats">
        <section class="stat-card" aria-label="Total notes">
            <div class="stat-label"><i class="bi bi-file-text" aria-hidden="true"></i><span>Total Notes</span></div>
            <p class="stat-value"><?php echo number_format(getTotalNotes()); ?></p>
        </section>
        <section class="stat-card" aria-label="Categories">
            <div class="stat-label"><i class="bi bi-folder2" aria-hidden="true"></i><span>Categories</span></div>
            <p class="stat-value"><?php echo number_format(getTotalCategories()); ?></p>
        </section>
    </div>

    <section class="recent-section">
        <div class="recent-heading">
            <h3>Recently Updated Notes</h3>
            <a href="<?php echo BASE_URL; ?>notes/index.php" class="view-all">View all <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
        </div>

        <?php $recentNotes = getRecentNotes(5); ?>

        <?php if (empty($recentNotes)): ?>
            <div class="empty-state">
                <i class="bi bi-journal" aria-hidden="true"></i>
                <h3>No notes yet</h3>
                <p>Create your first note to get started.</p>
                <a href="<?php echo BASE_URL; ?>notes/create.php" class="button button-primary">Create your first note</a>
            </div>
        <?php else: ?>
            <div class="recent-list">
                <?php foreach ($recentNotes as $note): ?>
                    <article class="recent-note">
                        <div class="note-title-row">
                            <h4><a href="<?php echo BASE_URL; ?>notes/view.php?id=<?php echo $note['id']; ?>"><?php echo sanitize($note['title']); ?></a></h4>
                            <time datetime="<?php echo htmlspecialchars($note['updated_at'], ENT_QUOTES, 'UTF-8'); ?>"><?php echo formatDate($note['updated_at'], 'M d, Y'); ?></time>
                        </div>
                        <?php
                        $categoryClass = match (strtolower(trim($note['category_name']))) {
                            'study' => 'category-study',
                            'personal' => 'category-personal',
                            default => 'category-other',
                        };
                        ?>
                        <div class="note-category"><span class="category-badge <?php echo $categoryClass; ?>"><?php echo sanitize($note['category_name']); ?></span></div>
                        <p class="note-preview"><?php echo sanitize(truncateText($note['content'], 150)); ?></p>
                        <div class="note-actions">
                            <a class="button button-secondary" href="<?php echo BASE_URL; ?>notes/view.php?id=<?php echo $note['id']; ?>">Read</a>
                            <a class="button button-secondary" href="<?php echo BASE_URL; ?>notes/edit.php?id=<?php echo $note['id']; ?>">Edit</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
