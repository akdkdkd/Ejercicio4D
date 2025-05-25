<?php
include_once LAYOUTS . 'main_head.php';
setHeader($d);
?>

<link rel="stylesheet" href="<?php echo CSS . 'index.css'; ?>">

<!-- Nuevo div que ocupa toda la pantalla y centra verticalmente -->
<div class="page-center d-flex justify-content-center align-items-center vh-100">
    <div class="container">
        <h2 class="text-center mb-5">Consultar Citas</h2>

        <form action="" id="consulta-cita" class="card p-4 shadow mx-auto mt-5 p-5" style="max-width: 500px;">
            <div class="form-group mb-3">
                <label for="curp">CURP</label>
                <input type="text" name="curp" id="curp" class="form-control" required  placeholder="Ingresa tu CURP">
            </div>

            <div class="form-group mb-4">
                <label for="email">Correo Electrónico</label>
                <input type="email" name="email" id="email" class="form-control" required placeholder="tucorreo@example.com">
            </div>
            <small class="form-text text- d-none" id="error">
                Los datos ingresados deben coincidir con los de la cita agendada.
            </small>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary" id="btnConsultarCita"
                >Consultar</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal para mostrar citas -->
<div class="modal fade" id="modalCitas" tabindex="-1" aria-labelledby="modalCitasLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCitasLabel">Tus Citas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div id="listaCitas" class="list-group">
          <!-- Aquí se inyectarán las citas dinámicamente -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



<?php
include_once LAYOUTS . 'main_foot.php';
setFooter($d);
?>

<script>
    $(function(){
        const $cita = $("#consulta-cita");
        $cita.on("submit", function(e){
            e.preventDefault();
            e.stopPropagation();
            const formData = new FormData(this);
            fetch( app.routes.consultaCitas, {
                method: "POST",
                body: formData
            }).then(resp => resp.json())
.then(resp => {
    if (resp.r !== false && Array.isArray(resp.r)) {
        console.log("Respuesta del servidor:", resp);
        const $lista = $("#listaCitas").empty();

        if (resp.r.length === 0) {
            $lista.append(`<div class="list-group-item">No se encontraron citas.</div>`);
        } else {
            resp.r.forEach(cita => {
                const fecha = new Date(cita.fecha);
                const fechaFormateada = fecha.toLocaleString('es-MX', {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                });

if (cita.estado === "Pendiente") {
    $lista.append(`
        <div class="list-group-item">
            <p><strong>Fecha:</strong> ${fechaFormateada}</p>
            <p><strong>Motivo:</strong> ${cita.motivo}</p>
            <p><strong>Estado:</strong> ${cita.estado}</p>
            <div class="d-flex justify-content-end gap-2 mt-3">
                <button class="btn btn-sm btn-warning" onclick="editarCita(${cita.id})">Editar</button>
                <button class="btn btn-sm btn-danger" onclick="cancelarCita(${cita.id})">Cancelar</button>
            </div>
        </div>
    `);
} else {
    $lista.append(`
        <div class="list-group-item">
            <p><strong>Fecha:</strong> ${fechaFormateada}</p>
            <p><strong>Motivo:</strong> ${cita.motivo}</p>
            <p><strong>Estado:</strong> ${cita.estado}</p>
        </div>
    `);
}


            });
        }

        const modal = new bootstrap.Modal(document.getElementById('modalCitas'));
        modal.show();
    } else {
        $("#error").removeClass("d-none");
    }
})
.catch(err => {
                console.error("Error:", err);
                $("#error").removeClass("d-none");
            });
        })
    })
</script>

<script>
    function editarCita(id) {
    console.log("Editar cita con ID:", id);
    // Aquí puedes redirigir al formulario de edición o abrir otro modal
}

function cancelarCita(id) {
    if (confirm("¿Estás seguro de que deseas cancelar esta cita?")) {
        fetch(app.routes.cancelarCita, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ id })
        })
        .then(resp => resp.json())
        .then(data => {
            console.log("Respuesta del servidor:", data);
            if (data) {
                alert("Cita cancelada correctamente.");
                // Puedes volver a consultar las citas automáticamente
                $("#consulta-cita").submit();
            } else {
                alert("Hubo un error al cancelar la cita.");
            }
        })
        .catch(err => {
            console.error("Error al cancelar la cita:", err);
        });
    }
}

</script>

<?php 
    closeFooter();
?>
