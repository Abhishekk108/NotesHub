    </main>

    <footer class="site-footer">
        <div>
            <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars(APP_NAME); ?>. All rights reserved.</p>
        </div>
    </footer>

    <!-- Scroll-to-top -->
    <button id="scrollTop"
            class="fixed bottom-6 right-6 w-11 h-11 bg-blue-600 text-white rounded-full shadow-lg
                   flex items-center justify-center text-lg font-bold
                   opacity-0 pointer-events-none transition-opacity duration-300
                   hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
            aria-label="Scroll to top" title="Back to top">↑</button>

    <script src="<?php echo BASE_URL; ?>assets/js/script.js"></script>
</body>
</html>
