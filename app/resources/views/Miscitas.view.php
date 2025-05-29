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
                <label for="curp">Numero de seguro</label>
                <input type="text" name="curp" id="curp" class="form-control" required  placeholder="Ingresa tu Numero de Seguro">
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

<!-- Modal para editar cita -->
<div class="modal fade" id="modalEditarCita" tabindex="-1" aria-labelledby="modalEditarCitaLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditarCitaLabel">Editar Cita</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="formEditarCita">
          <input type="hidden" id="editarCitaId">
          <div class="mb-3">
            <label for="editarFecha" class="form-label">Fecha</label>
            <input type="date" class="form-control" id="editarFecha" required>
          </div>
            <div class="mb-3">
            <label for="editarHora" class="form-label">Hora</label>
            <select class="form-control" id="editarHora" required>
                <option value="" disabled selected>Selecciona una hora</option>
                <!-- Opciones de 07:00 a 14:00 cada 30 minutos -->
                <?php
                for ($h = 7; $h <= 14; $h++) {
                    $hora = str_pad($h, 2, '0', STR_PAD_LEFT);
                    echo "<option value='{$hora}:00'>{$hora}:00</option>";
                    if ($h < 14) echo "<option value='{$hora}:30'>{$hora}:30</option>";
                }
                ?>
            </select>
            </div>

          <div class="mb-3">
            <label for="editarMotivo" class="form-label">Motivo</label>
            <input type="text" class="form-control" id="editarMotivo" required>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar cambios</button>
          </div>
        </form>
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
            <p><strong>Fecha:</strong> ${cita.fecha}</p>
            <p><strong>Hora:</strong> ${cita.hora}</p>
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
            <p><strong>Fecha:</strong> ${cita.fecha}</p>
            <p><strong>Hora:</strong> ${cita.hora}</p>
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
    // Obtener la cita desde la lista mostrada
    const cita = Array.from(document.querySelectorAll("#listaCitas .list-group-item"))
        .map(el => {
            return {
                id: id,
                fecha: el.querySelector("p:nth-child(1)")?.innerText.split(": ")[1],
                hora: el.querySelector("p:nth-child(2)")?.innerText.split(": ")[1],
                motivo: el.querySelector("p:nth-child(3)")?.innerText.split(": ")[1],
            };
        }).find(c => c.id == id);

    if (!cita) return alert("No se pudo encontrar la cita para editar.");

    // Rellenar campos del formulario de edición
    document.getElementById("editarCitaId").value = id;
    document.getElementById("editarFecha").value = cita.fecha.split("T")[0] || "";
    document.getElementById("editarHora").value = cita.hora || "";
    document.getElementById("editarMotivo").value = cita.motivo || "";
    

    const modalEditar = new bootstrap.Modal(document.getElementById("modalEditarCita"));
    modalEditar.show();
}




function cancelarCita(id) {
    if (confirm("¿Estás seguro de que deseas cancelar esta cita?  ")) {
        fetch(app.routes.cancelarCita, {
            method: "POST",
            body: JSON.stringify({ id: id }),
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
<script>
document.getElementById("formEditarCita").addEventListener("submit", function(e) {
    e.preventDefault();
    e.stopPropagation();

    const citaEditada = {
        id: document.getElementById("editarCitaId").value,
        fecha: document.getElementById("editarFecha").value,
        hora: document.getElementById("editarHora").value,
        motivo: document.getElementById("editarMotivo").value
    };

    // Realiza el fetch (tú puedes modificar la URL y el cuerpo según tus necesidades)
    fetch(app.routes.actualizarCita, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(citaEditada)
    })
    .then(resp => resp.json())
    .then(data => {
        console.log("Respuesta del servidor al editar:", data);
        if (data && data.success) {
            alert("Cita actualizada correctamente.");
            bootstrap.Modal.getInstance(document.getElementById("modalEditarCita")).hide();
            // Opcionalmente recarga las citas
            document.getElementById("consulta-cita").dispatchEvent(new Event("submit"));
        } else {
            alert("Hubo un error al actualizar la cita.");
        }
    })
    .catch(err => {
        console.error("Error al editar la cita:", err);
        alert("Error en la solicitud.");
    });
});
</script>


<?php 
    closeFooter();
?>
