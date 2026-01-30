
<!-- ================= FOOTER ================= -->
<footer class="bg-gray-900 text-gray-300">
   

    <div class="text-center text-sm py-4 bg-gray-950">
        © 2026 {{ get_option('site_title') }}
    </div>
</footer>
<script>
    const toggle = document.getElementById('menu-toggle');
    const menu   = document.getElementById('mobile-menu');

    toggle.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>

</body>
</html>
