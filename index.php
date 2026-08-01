<?php
require_once __DIR__ . '/includes/functions.php';
include __DIR__ . '/includes/header.php';
?>

<div class="animate-fade-in">

    <!-- Page heading -->
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-1">Welcome to Noteshub</h2>
        <p class="text-slate-500">Manage your notes and categories in one place.</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-8">

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex items-center gap-5 hover:shadow-md transition-shadow">
            <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center text-2xl flex-shrink-0">📝</div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-0.5">Total Notes</p>
                <p class="text-4xl font-extrabold text-slate-800 leading-none"><?php echo number_format(getTotalNotes()); ?></p>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex items-center gap-5 hover:shadow-md transition-shadow">
            <div class="w-14 h-14 rounded-xl bg-violet-50 flex items-center justify-center text-2xl flex-shrink-0">📂</div>
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-widest mb-0.5">Total Categories</p>
                <p class="text-4xl font-extrabold text-slate-800 leading-none"><?php echo number_format(getTotalCategories()); ?></p>
            </div>
        </div>

    </div>

    <!-- Recent Notes -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">

        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100">
            <h3 class="text-base font-bold text-slate-800">Recently Updated Notes</h3>
            <a href="<?php echo BASE_URL; ?>notes/index.php"
               class="text-sm font-semibold text-blue-600 hover:text-blue-800 transition-colors">
                View All →
            </a>
        </div>

        <?php $recentNotes = getRecentNotes(5); ?>

        <?php if (empty($recentNotes)): ?>
            <div class="text-center py-16 px-6">
                <div class="text-5xl mb-4">📝</div>
                <h3 class="text-lg font-bold text-slate-700 mb-1">No notes yet</h3>
                <p class="text-slate-500 text-sm mb-5">Create your first note to get started.</p>
                <a href="<?php echo BASE_URL; ?>notes/create.php"
                   class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors">
                    Create Your First Note
                </a>
            </div>
        <?php else: ?>
            <ul class="divide-y divide-slate-100">
                <?php foreach ($recentNotes as $note): ?>
                    <li class="px-6 py-4 hover:bg-slate-50 transition-colors">
                        <div class="flex items-start justify-between gap-4 mb-1">
                            <h4 class="text-sm font-semibold text-slate-800">
                                <a href="<?php echo BASE_URL; ?>notes/view.php?id=<?php echo $note['id']; ?>"
                                   class="hover:text-blue-600 transition-colors">
                                    <?php echo sanitize($note['title']); ?>
                                </a>
                            </h4>
                            <span class="text-xs text-slate-400 whitespace-nowrap flex-shrink-0">
                                <?php echo formatDate($note['updated_at'], 'M d, Y'); ?>
                            </span>
                        </div>
                        <div class="mb-2">
                            <span class="inline-block bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                <?php echo sanitize($note['category_name']); ?>
                            </span>
                        </div>
                        <p class="text-sm text-slate-500 leading-relaxed mb-3">
                            <?php echo sanitize(truncateText($note['content'], 150)); ?>
                        </p>
                        <div class="flex items-center gap-2 pt-2 border-t border-slate-100">
                            <a href="<?php echo BASE_URL; ?>notes/view.php?id=<?php echo $note['id']; ?>"
                               class="text-xs font-semibold text-blue-600 hover:bg-blue-50 px-2.5 py-1 rounded transition-colors">
                                Read
                            </a>
                            <a href="<?php echo BASE_URL; ?>notes/edit.php?id=<?php echo $note['id']; ?>"
                               class="text-xs font-semibold text-slate-500 hover:bg-slate-100 px-2.5 py-1 rounded transition-colors">
                                Edit
                            </a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    </div>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
