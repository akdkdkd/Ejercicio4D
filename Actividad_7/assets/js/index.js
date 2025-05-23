document.getElementById('btnAgendarCita').addEventListener('click', function () {
    const modal = new bootstrap.Modal(document.getElementById('modalAgendarCita'));
    modal.show();
});

  // Ejemplo de manejo del formulario (lógica temporal)
document.getElementById('formAgendarCita').addEventListener('submit', function (e) {
    e.preventDefault();
    alert('Cita agendada correctamente (aún falta guardar en localStorage).');
    bootstrap.Modal.getInstance(document.getElementById('modalAgendarCita')).hide();
    this.reset();
});