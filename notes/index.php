<?php
require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';

// Read and sanitise filter/sort inputs
$searchQuery = isset($_GET['q'])           ? trim($_GET['q'])           : '';
$categoryId  = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$sort        = isset($_GET['sort'])        ? $_GET['sort']              : 'latest';

// Whitelist sort values so nothing unexpected reaches the function
$allowedSorts = ['latest', 'oldest', 'alpha'];
if (!in_array($sort, $allowedSorts, true)) {
    $sort = 'latest';
}

$notes      = searchNotes($searchQuery, $categoryId, $sort);
$categories = getAllCategories();

$isFiltered = $searchQuery !== '' || $categoryId > 0;

// Human-readable label for the active sort
$sortLabels = [
    'latest' => 'Latest first',
    'oldest' => 'Oldest first',
    'alpha'  => 'A → Z',
];
?>

<section class="notes-section">
    <div class="page-header">
        <div>
            <h2>All Notes</h2>
            <p>Manage and organize your notes</p>
        </div>
        <a href="<?php echo BASE_URL; ?>notes/create.php" class="btn btn-primary">+ Create Note</a>
    </div>

    <!-- Search, Filter & Sort Bar -->
    <form method="GET" class="search-bar" role="search">
        <div class="search-input-wrap">
            <span class="search-icon">🔍</span>
            <input
                type="text"
                name="q"
                value="<?php echo sanitize($searchQuery); ?>"
                placeholder="Search by title or content…"
                class="search-input"
                aria-label="Search notes"
            >
        </div>

        <select name="category_id" class="search-select" aria-label="Filter by category">
            <option value="0">All Categories</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?php echo $cat['id']; ?>" <?php echo $categoryId === (int)$cat['id'] ? 'selected' : ''; ?>>
                    <?php echo sanitize($cat['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="sort" class="search-select" aria-label="Sort notes">
            <?php foreach ($sortLabels as $value => $label): ?>
                <option value="<?php echo $value; ?>" <?php echo $sort === $value ? 'selected' : ''; ?>>
                    <?php echo $label; ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn btn-primary search-btn">Search</button>

        <?php if ($isFiltered || $sort !== 'latest'): ?>
            <a href="<?php echo BASE_URL; ?>notes/index.php" class="btn btn-secondary search-btn">Clear</a>
        <?php endif; ?>
    </form>

    <!-- Results summary -->
    <?php if ($isFiltered || $sort !== 'latest'): ?>
        <p class="search-results-summary">
            <?php echo count($notes); ?> <?php echo count($notes) === 1 ? 'note' : 'notes'; ?>

            <?php if ($isFiltered): ?>
                <?php if ($searchQuery !== ''): ?>
                    matching <strong>&ldquo;<?php echo sanitize($searchQuery); ?>&rdquo;</strong>
                <?php endif; ?>
                <?php if ($categoryId > 0): ?>
                    <?php foreach ($categories as $cat): ?>
                        <?php if ((int)$cat['id'] === $categoryId): ?>
                            in <strong><?php echo sanitize($cat['name']); ?></strong>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
                &mdash;
            <?php endif; ?>

            sorted by <strong><?php echo $sortLabels[$sort]; ?></strong>
        </p>
    <?php endif; ?>

    <?php if (empty($notes)): ?>
        <?php if ($isFiltered): ?>
            <div class="empty-state">
                <div class="empty-icon">🔍</div>
                <h3>No notes found</h3>
                <p>Try a different search term or category filter.</p>
                <a href="<?php echo BASE_URL; ?>notes/index.php" class="btn btn-secondary">Clear Filters</a>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">📝</div>
                <h3>No notes yet</h3>
                <p>Start by creating your first note.</p>
                <a href="<?php echo BASE_URL; ?>notes/create.php" class="btn btn-primary">Create Your First Note</a>
            </div>
        <?php endif; ?>
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
