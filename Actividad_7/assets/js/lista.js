const sidebar = document.getElementById('sidebar');
const toggleSidebar = document.getElementById('toggleSidebar');

// Alterna clase .show a la sidebar y clase .active al botón
toggleSidebar.addEventListener('click', () => {
    sidebar.classList.toggle('show');
    toggleSidebar.classList.toggle('active');
});