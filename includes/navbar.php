<nav class="bg-white border-b border-slate-200 shadow-sm sticky top-0 z-50" aria-label="Main navigation">
    <div class="max-w-6xl mx-auto px-6">
        <div class="flex items-center justify-between">

            <!-- Mobile hamburger -->
            <button id="navToggle"
                    class="md:hidden flex flex-col justify-center gap-1.5 w-9 h-9 rounded-md hover:bg-slate-100 transition p-1.5"
                    aria-expanded="false" aria-controls="navMenu" aria-label="Toggle navigation">
                <span class="block h-0.5 bg-slate-700 rounded transition-all"></span>
                <span class="block h-0.5 bg-slate-700 rounded transition-all"></span>
                <span class="block h-0.5 bg-slate-700 rounded transition-all"></span>
            </button>

            <!-- Nav links -->
            <ul id="navMenu"
                class="flex-col md:flex-row gap-0 md:gap-1 w-full md:w-auto
                       absolute md:static top-full left-0 right-0
                       bg-white md:bg-transparent
                       border-b md:border-0 border-slate-200
                       shadow-md md:shadow-none
                       py-2 md:py-0 px-4 md:px-0"
                role="list">
                <li><a href="<?php echo BASE_URL; ?>"
                       class="flex items-center gap-1.5 px-3 py-2.5 md:py-4 text-sm font-medium text-slate-600 rounded-md hover:text-blue-600 hover:bg-blue-50 transition-colors">
                    🏠 <span>Home</span>
                </a></li>
                <li><a href="<?php echo BASE_URL; ?>notes/index.php"
                       class="flex items-center gap-1.5 px-3 py-2.5 md:py-4 text-sm font-medium text-slate-600 rounded-md hover:text-blue-600 hover:bg-blue-50 transition-colors">
                    📝 <span>Notes</span>
                </a></li>
                <li><a href="<?php echo BASE_URL; ?>categories/index.php"
                       class="flex items-center gap-1.5 px-3 py-2.5 md:py-4 text-sm font-medium text-slate-600 rounded-md hover:text-blue-600 hover:bg-blue-50 transition-colors">
                    📂 <span>Categories</span>
                </a></li>
                <li><a href="<?php echo BASE_URL; ?>notes/create.php"
                       class="flex items-center gap-1.5 px-3 py-2.5 md:py-4 text-sm font-medium text-slate-600 rounded-md hover:text-blue-600 hover:bg-blue-50 transition-colors">
                    ✏️ <span>New Note</span>
                </a></li>
                <li><a href="<?php echo BASE_URL; ?>categories/create.php"
                       class="flex items-center gap-1.5 px-3 py-2.5 md:py-4 text-sm font-medium text-slate-600 rounded-md hover:text-blue-600 hover:bg-blue-50 transition-colors">
                    ➕ <span>New Category</span>
                </a></li>
            </ul>

        </div>
    </div>
</nav>
