const sidebar = document.querySelector('.sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('active');
    });