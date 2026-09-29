<nav class="site-nav" aria-label="Main navigation">
    <div class="site-nav-inner">
        <a class="site-brand" href="<?php echo BASE_URL; ?>">
            <i class="bi bi-journal-text" aria-hidden="true"></i>
            <span><?php echo htmlspecialchars(APP_NAME); ?></span>
        </a>

        <button id="navToggle" class="nav-toggle" type="button"
                aria-expanded="false" aria-controls="navMenu" aria-label="Toggle navigation">
            <span></span><span></span><span></span>
        </button>

        <ul id="navMenu" class="nav-menu" role="list">
            <li><a href="<?php echo BASE_URL; ?>">Home</a></li>
            <li><a href="<?php echo BASE_URL; ?>notes/index.php">Notes</a></li>
            <li><a href="<?php echo BASE_URL; ?>categories/index.php">Categories</a></li>
            <li><a class="nav-primary" href="<?php echo BASE_URL; ?>notes/create.php">
                <i class="bi bi-plus-lg" aria-hidden="true"></i><span>New Note</span>
            </a></li>
        </ul>
    </div>
</nav>
