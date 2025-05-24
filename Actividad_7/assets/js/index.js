document.getElementById('btnAgendarCita').addEventListener('click', function () {
    const modal = new bootstrap.Modal(document.getElementById('modalAgendarCita'));
    modal.show();
});

document.getElementById('formAgendarCita').addEventListener('submit', function (e) {
    e.preventDefault();
    alert('Cita agendada correctamente (aún falta guardar en localStorage).');
    bootstrap.Modal.getInstance(document.getElementById('modalAgendarCita')).hide();
    this.reset();
});

// Botón de la sidebar mostrar/ocultar el sidebar en pantallas pequeñas

document.getElementById('menuToggle').addEventListener('click', () => {
    const sidebar = document.getElementById('sidebar');
    const toggleButton = document.getElementById('menuToggle');

    sidebar.classList.toggle('show');

    // Verifica si la sidebar está visible y cambia el color del botón
    if (sidebar.classList.contains('show')) {
        toggleButton.classList.add('on-sidebar');
    } else {
        toggleButton.classList.remove('on-sidebar');
    }
});
