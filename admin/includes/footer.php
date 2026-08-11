</main>

</div>


<script>

    lucide.createIcons();


    // ==================================================
    // SIDEBAR MOBILE
    // ==================================================

    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebar-overlay');
    const toggle = document.getElementById('sidebar-toggle');


    if (toggle) {

        toggle.addEventListener('click', function () {

            sidebar.classList.remove('-translate-x-full');

            overlay.classList.remove('hidden');

        });

    }


    if (overlay) {

        overlay.addEventListener('click', function () {

            sidebar.classList.add('-translate-x-full');

            overlay.classList.add('hidden');

        });

    }

</script>

</body>

</html>