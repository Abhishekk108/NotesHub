<?php
require_once __DIR__ . '/../includes/functions.php';
include __DIR__ . '/../includes/header.php';

$searchQuery = isset($_GET['q'])           ? trim($_GET['q'])           : '';
$categoryId  = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$sort        = isset($_GET['sort'])        ? $_GET['sort']              : 'latest';

$allowedSorts = ['latest', 'oldest', 'alpha'];
if (!in_array($sort, $allowedSorts, true)) $sort = 'latest';

$notes      = searchNotes($searchQuery, $categoryId, $sort);
$categories = getAllCategories();
$isFiltered = $searchQuery !== '' || $categoryId > 0;

$sortLabels = ['latest' => 'Latest first', 'oldest' => 'Oldest first', 'alpha' => 'A → Z'];
?>

<!-- Page header -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6 pb-5 border-b border-slate-200">
    <div>
        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">All Notes</h2>
        <p class="text-slate-500 text-sm mt-0.5">Manage and organize your notes</p>
    </div>
    <a href="<?php echo BASE_URL; ?>notes/create.php"
       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2.5 rounded-lg transition-colors shadow-sm whitespace-nowrap">
        + Create Note
    </a>
</div>

<!-- Search / Filter / Sort -->
<form method="GET" role="search"
      class="bg-white border border-slate-200 rounded-xl shadow-sm p-4 mb-5 flex flex-wrap items-center gap-3">

    <div class="flex items-center flex-1 min-w-48 bg-slate-50 border border-slate-200 rounded-lg px-3 focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-100 transition">
        <i class="bi bi-search text-slate-400 mr-2 text-sm" aria-hidden="true"></i>
        <input type="text" name="q"
               value="<?php echo sanitize($searchQuery); ?>"
               placeholder="Search by title or content…"
               class="flex-1 bg-transparent py-2 text-sm text-slate-700 placeholder-slate-400 outline-none"
               aria-label="Search notes">
    </div>

    <select name="category_id"
            class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition cursor-pointer"
            aria-label="Filter by category">
        <option value="0">All Categories</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?php echo $cat['id']; ?>" <?php echo $categoryId === (int)$cat['id'] ? 'selected' : ''; ?>>
                <?php echo sanitize($cat['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <select name="sort"
            class="bg-slate-50 border border-slate-200 rounded-lg px-3 py-2 text-sm text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition cursor-pointer"
            aria-label="Sort notes">
        <?php foreach ($sortLabels as $value => $label): ?>
            <option value="<?php echo $value; ?>" <?php echo $sort === $value ? 'selected' : ''; ?>>
                <?php echo $label; ?>
            </option>
        <?php endforeach; ?>
    </select>

    <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
        Search
    </button>

    <?php if ($isFiltered || $sort !== 'latest'): ?>
        <a href="<?php echo BASE_URL; ?>notes/index.php"
           class="bg-white border border-slate-200 hover:border-slate-300 text-slate-600 text-sm font-semibold px-4 py-2 rounded-lg transition-colors">
            Clear
        </a>
    <?php endif; ?>
</form>

<!-- Results summary -->
<?php if ($isFiltered || $sort !== 'latest'): ?>
    <p class="text-sm text-slate-500 mb-4">
        <span class="font-semibold text-slate-700"><?php echo count($notes); ?></span>
        <?php echo count($notes) === 1 ? 'note' : 'notes'; ?>
        <?php if ($searchQuery !== ''): ?>
            matching <strong class="text-slate-700">&ldquo;<?php echo sanitize($searchQuery); ?>&rdquo;</strong>
        <?php endif; ?>
        <?php if ($categoryId > 0): ?>
            <?php foreach ($categories as $cat): ?>
                <?php if ((int)$cat['id'] === $categoryId): ?>
                    in <strong class="text-slate-700"><?php echo sanitize($cat['name']); ?></strong>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
        &mdash; sorted by <strong class="text-slate-700"><?php echo $sortLabels[$sort]; ?></strong>
    </p>
<?php endif; ?>

<!-- Empty states -->
<?php if (empty($notes)): ?>
    <div class="bg-white border-2 border-dashed border-slate-200 rounded-2xl text-center py-16 px-6">
        <div class="text-2xl text-slate-400 mb-4"><i class="bi <?php echo $isFiltered ? 'bi-search' : 'bi-journal'; ?>" aria-hidden="true"></i></div>
        <h3 class="text-lg font-bold text-slate-700 mb-1">
            <?php echo $isFiltered ? 'No notes found' : 'No notes yet'; ?>
        </h3>
        <p class="text-slate-500 text-sm mb-5">
            <?php echo $isFiltered ? 'Try a different search term or category filter.' : 'Start by creating your first note.'; ?>
        </p>
        <?php if ($isFiltered): ?>
            <a href="<?php echo BASE_URL; ?>notes/index.php"
               class="inline-flex items-center gap-2 border border-slate-300 hover:border-slate-400 text-slate-700 text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                Clear Filters
            </a>
        <?php else: ?>
            <a href="<?php echo BASE_URL; ?>notes/create.php"
               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                Create Your First Note
            </a>
        <?php endif; ?>
    </div>

<?php else: ?>
    <!-- Notes grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php foreach ($notes as $note): ?>
            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm flex flex-col hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">

                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <h3 class="text-sm font-bold text-slate-800 leading-snug">
                            <a href="<?php echo BASE_URL; ?>notes/view.php?id=<?php echo $note['id']; ?>"
                               class="hover:text-blue-600 transition-colors">
                                <?php echo sanitize($note['title']); ?>
                            </a>
                        </h3>
                        <span class="inline-block bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-0.5 rounded-full whitespace-nowrap flex-shrink-0">
                            <?php echo sanitize($note['category_name']); ?>
                        </span>
                    </div>

                    <p class="text-xs text-slate-400 mb-3">
                        Updated <?php echo formatDate($note['updated_at'], 'M d, Y'); ?>
                    </p>

                    <p class="text-sm text-slate-500 leading-relaxed flex-1">
                        <?php echo sanitize(truncateText($note['content'], 150)); ?>
                    </p>
                </div>

                <div class="flex border-t border-slate-100">
                    <a href="<?php echo BASE_URL; ?>notes/view.php?id=<?php echo $note['id']; ?>"
                       class="flex-1 text-center text-xs font-semibold text-blue-600 hover:bg-blue-50 py-2.5 transition-colors rounded-bl-2xl">
                        View
                    </a>
                    <a href="<?php echo BASE_URL; ?>notes/edit.php?id=<?php echo $note['id']; ?>"
                       class="flex-1 text-center text-xs font-semibold text-amber-600 hover:bg-amber-50 py-2.5 border-x border-slate-100 transition-colors">
                        Edit
                    </a>
                    <a href="<?php echo BASE_URL; ?>notes/delete.php?id=<?php echo $note['id']; ?>"
                       class="flex-1 text-center text-xs font-semibold text-red-500 hover:bg-red-50 py-2.5 transition-colors rounded-br-2xl"
                       onclick="return confirm('Are you sure you want to delete this note?');">
                        Delete
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../includes/footer.php'; ?>
