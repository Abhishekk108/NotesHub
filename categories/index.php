<?php
require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';

$categories = getCategoriesWithStats();
?>

<section class="categories-section">
    <div class="page-header">
        <div>
            <h2>Categories</h2>
            <p>Manage your note categories</p>
        </div>
        <a href="<?php echo BASE_URL; ?>categories/create.php" class="btn btn-primary">+ New Category</a>
    </div>

    <?php if (empty($categories)): ?>
        <div class="empty-state">
            <div class="empty-icon">📂</div>
            <h3>No categories yet</h3>
            <p>Start by creating your first category.</p>
            <a href="<?php echo BASE_URL; ?>categories/create.php" class="btn btn-primary">Create Your First Category</a>
        </div>
    <?php else: ?>
        <div class="categories-grid">
            <?php foreach ($categories as $category): ?>
                <div class="category-card">
                    <div class="card-icon">📁</div>
                    <div class="card-content">
                        <h3><?php echo sanitize($category['name']); ?></h3>
                        <p class="card-stats"><?php echo $category['note_count']; ?> <?php echo $category['note_count'] === 1 ? 'note' : 'notes'; ?></p>
                        <p class="card-date">Created: <?php echo formatDate($category['created_at'], 'M d, Y'); ?></p>
                    </div>
                    <div class="card-actions">
                        <a href="<?php echo BASE_URL; ?>categories/edit.php?id=<?php echo $category['id']; ?>" class="action-btn action-edit" title="Edit category">Edit</a>
                        <a href="<?php echo BASE_URL; ?>categories/delete.php?id=<?php echo $category['id']; ?>" class="action-btn action-delete" title="Delete category" onclick="return confirm('Are you sure you want to delete this category and all its notes?');">Delete</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>