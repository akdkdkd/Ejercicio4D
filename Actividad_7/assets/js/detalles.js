document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('toggleSidebar');
    const sidebar = document.getElementById('sidebar');

    // Solo ocultar inicialmente en móviles
    if (window.innerWidth <= 768) {
        sidebar.classList.add('hidden');
    }

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('hidden');
    });

    // Opcional: Ocultar sidebar al cambiar tamaño de ventana
    window.addEventListener('resize', () => {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('hidden');
        } else {
            sidebar.classList.add('hidden');
        }
    });
});