<?php
    include_once LAYOUTS . 'main_head.php';

    setHeader($d);

?>

<style>
    /* Reset básico */
* {
    margin: 0;
    padding: 0;
    text-decoration: none;
    box-sizing: border-box;
}

body {
    background-color: #f8f9fa; /* Blanco ligeramente grisáceo */
    font-family: Arial, sans-serif;
    padding-top: 60px; /* Para dejar espacio a la topbar */
    padding-left: 250px; /* Para dejar espacio a la sidebar */
}

/* Sidebar section styles */
.sidebar {
    width: 250px;
    background: #6a1b9a;
    color: white;
    display: flex;
    flex-direction: column;
    padding: 1rem;
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    z-index: 1050; /* por encima de topbar y contenido */
    transform: translateX(-100%);
    transition: transform 0.3s ease;
}
.sidebar.show {
    transform: translateX(0);
}

.sidebar .brand {
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: bold;
    margin-bottom: 2rem;
    text-decoration: none;
    color: white;
}

.sidebar .side-menu {
    list-style: none;
}

.sidebar .side-menu li {
    margin: 1rem 0;
}

.sidebar .side-menu a {
    color: white;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-size: 1rem;
    padding: 0.5rem;
    transition: background 0.3s;
}

.sidebar .side-menu a:hover {
    background: #8e24aa;
    border-radius: 0.5rem;
}

/* Topbar section styles */
.topbar {
    width: calc(100% - 250px);
    
    height: 60px;
    background: white;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 0 1rem;
    box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
    position: fixed;
    top: 0;
    z-index: 999;
}

/* Encabezado de bienvenida */
h1.text-center.mt-4,
p.text-center {
    text-align: center !important;
    margin-left: 0;
    margin-right: 0;
}
.content {
    margin-top: 60px;
    margin-left: 250px;
    padding: 2rem;
    flex-grow: 1;
}
/* Ajustes para el contenedor general */
.container {
    max-width: 960px;
    margin-left: auto;
    margin-right: auto;
}

/* Cartas */
.card {
    height: 250px;
    background: white;
    padding: 1.5rem;
    border-radius: 1rem;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    text-align: center;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.card:hover {
    transform: translateY(-5px);
}

.card-body i {
    display: block;
    margin-top: 1rem;
}

/* Botón de agendar cita */
#btnAgendarCita {
    margin-top: 2rem;
    padding: 0.75rem 1.5rem;
    font-size: 1.1rem;
}

/* Modal */
.modal-content {
    border-radius: 0.5rem;
}

.modal-header,
.modal-footer {
    background-color: #f1f1f1;
}

.modal-title {
    font-weight: bold;
}
.sidebar {
    transform: translateX(0);
    transition: transform 0.3s ease;
}

.sidebar.hidden {
    transform: translateX(-100%);
}

/* Ajustes para topbar y contenido cuando sidebar esté oculto */
body.sidebar-hidden .topbar {
    margin-left: 0;
    width: 100%;
}

body.sidebar-hidden .content {
    margin-left: 0;
}

.container {
    max-width: 960px;
    margin-left: auto;
    margin-right: auto;
}
body.sidebar-hidden {
    padding-left: 0;
}

body.sidebar-hidden .topbar {
    width: 100%;
}

body.sidebar-hidden .content {
    margin-left: 0;
}

/* opcion de responsividad */
@media (max-width: 768px) {
    .container {
        grid-template-columns: 1fr;
    }

    .card {
        width: 100%;
    }

    .appointment-card {
        grid-column: 1;
        width: 100%;
    }
}
</style>


    <!-- Content section -->
    <h1 class="text-center mt-4">Consultorio Jade</h1>
    <p class="text-center">Gestión de citas</p>


    <!-- End of Content section -->

    <div class="home mt-5" id="home">

    </div>

    <div class="container text-center my-5">
        <button class="btn btn-primary btn-lg" id="btnAgendarCita" data-bs-toggle="modal" data-bs-target="#modalAgendarCita">
            <i class="bi bi-calendar-plus me-2"></i> Agendar Cita
        </button>
    </div>

    <!-- Modal para Agendar Cita -->
    <div class="modal fade" id="modalAgendarCita" tabindex="-1" aria-labelledby="modalAgendarCitaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" id="formAgendarCita">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgendarCitaLabel">Agendar Nueva Cita</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">

                        <!-- Nombre del paciente -->
                        <div class="mb-3">
                            <label for="numero_seguro" class="form-label">Numero de seguro</label>
                            <input type="text" name="numero_seguro" class="form-control" id="numero_seguro" required>
                        </div>

                        <!-- Día -->
                        <div class="mb-3">
                            <label for="fechaCita" class="form-label">Fecha</label>
                            <input type="date" class="form-control" name="fechaCita" id="fechaCita" required>
                        </div>
                    
                        <div class="mb-3">

                        </div>

                        <!-- Hora -->
                        <!-- Hora -->
                        <div class="mb-3">
                            <label for="doctor" class="form-label">Doctor / Especialista</label>
                            <select class="form-control doctor" name="doctor" id="doctor" required>
                                
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="horaCita" class="form-label">Hora</label>
                            <select class="form-control" name="horaCita" id="horaCita" required>
                                <option value="" disabled selected>Selecciona una hora</option>
                                <option value="07:00">07:00</option>
                                <option value="07:30">07:30</option>
                                <option value="08:00">08:00</option>
                                <option value="08:30">08:30</option>
                                <option value="09:00">09:00</option>
                                <option value="09:30">09:30</option>
                                <option value="10:00">10:00</option>
                                <option value="10:30">10:30</option>
                                <option value="11:00">11:00</option>
                                <option value="11:30">11:30</option>
                                <option value="12:00">12:00</option>
                                <option value="12:30">12:30</option>
                                <option value="13:00">13:00</option>
                                <option value="13:30">13:30</option>
                                <option value="14:00">14:00</option>
                            </select>
                        </div>

                    
                        <!-- Motivo -->
                        <div class="mb-3">
                            <label for="motivoCita" class="form-label">Motivo de la cita</label>
                            <textarea class="form-control" name="motivo" id="motivoCita" rows="4" maxlength="1000" required></textarea>
                            <div class="form-text">Máximo 1000 caracteres.</div>
                        </div>
                    
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Guardar Cita</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php

    include_once LAYOUTS . 'main_foot.php';
    setFooter($d);
?>

    <script>
        $( function(){
            app.loadinicio()
            // app.lastPost();
        })
        
    </script>
<script>
    $(async function () {
        const $doctorSelect = $("#doctor");
        let html = "";

        try {
            let doctores = await $.getJSON(app.routes.getDoctores);
            console.log("Tipo de doctores:", typeof doctores);
            console.log("Doctores recibidos:", doctores);

            // Parsear si viene como string
            if (typeof doctores === "string") {
                doctores = JSON.parse(doctores);
            }

            if (Array.isArray(doctores) && doctores.length > 0) {
                html = `<option value="" disabled selected>Selecciona un doctor</option>`;
                doctores.forEach(doctor => {
                    html += `<option value="${doctor.id}">${doctor.name} - ${doctor.especialidad}</option>`;
                });
            } else {
                html = `<option value="" disabled selected>No hay doctores disponibles</option>`;
            }
        } catch (error) {
            console.error("Error al obtener los doctores:", error);
            html = `<option value="" disabled selected>Error al cargar doctores</option>`;
        }

        $doctorSelect.html(html);
    });
</script>


<script>
    $(function(){
        const $form = $("#formAgendarCita")
        $form.on("submit", function(e){
            e.preventDefault();
            e.stopPropagation();
            const data = new FormData(this);
            // console.log("Datos del formulario:", data);
            fetch('/Citas/agendaCita', {
                method: 'POST',
                body: data
            }).then(resp => resp.json())
              .then(resp =>{
                if(resp.r !== false){
                    // Mostrar mensaje de éxito
                    alert("Cita agendada exitosamente");
                    // Cerrar el modal
                    $("#modalAgendarCita").modal('hide');
                    // Limpiar el formulario
                    $form[0].reset();
                } else {
                    // Mostrar mensaje de error
                    alert("El numero de seguro es incorrecto o no existe");
                }
            }).catch(err => {
                console.error("Error al agendar la cita:", err);
                alert("Ocurrió un error al procesar tu solicitud.");
            })
        })
    })
</script>


    

<?php 
    closeFooter();