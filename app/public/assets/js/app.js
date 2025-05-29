const app = {
    routes: {
        home: '/home',
        inisession: '/Session/iniSession',
        login: '/Session/userAuth',
        register: '/Register/register',
        citas: '/Citas/getCitas',
        getPacientes: '/Pacientes/getPacientes',
        getlitas: '/Citas/getlista',
        inicio: '/Home/getHome',
        consultaCitas: '/Citas/consultaCitas',
        cancelarCita: '/Citas/cancelarCita',
        getDoctores: '/Doctores/doctores',
        getHoras: '/Citas/getHoras',
        agendarCita: '/Citas/agendaCita',
        actualizarCita: '/Citas/actualizarCita',
        completarCita: '/Citas/completarCita',
    },
    user: {
        sv: false,
        id: '',
        username: '',
    },
    $pp: $('#prev-posts'),
    $lp: $('#content'),
    $list: $('#list'),
    $inicio: $('#home'),

    currentCitas: [], // Aquí almacenaremos las citas cargadas

    inicio: function (number) {
        // console.log($number);
        return `
            <div class="row text-center">

            <!-- Doctores activos -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Doctores Activos</h5>
                        <p class="display-4" id="activeDoctors">${number[0].tt}</p>
                        <i class="bi bi-person-badge text-primary" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>

            <!-- Pacientes registrados -->
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title">Pacientes Registrados</h5>
                        <p class="display-4" id="registeredPatients">${number[1].tt}</p> <!-- Igual aquí -->
                        <i class="bi bi-people text-success" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>

        </div>
        `
    },



    mainPostHTMLBuilder: function (citas) {
        console.log(citas);
        // Verifica que citas tenga al menos 4 elementos para evitar errores
        if (!citas || citas.length < 4) return '<p>No hay datos suficientes para mostrar.</p>';
        return `
            <div class="container">
                <div class="card doctor-card">
                    <h1>${citas[3].tt} de ${citas[2].tt}</h1>
                    <p>DOCTORES DISPONIBLES</p>
                </div>
                <div class="card patient-card">
                    <h1>${citas[1].tt}</h1>
                    <p>PACIENTES</p>
                </div>
                <div class="card appointment-card">
                    <h1>${citas[0].tt}</h1>
                    <p>TOTAL DE CITAS DEL DÍA</p>
                </div>
            </div>
        `;
    },

    // Inserta el HTML del modal en el body
    renderModal: function (data) {
        // Cambié print por console.log para evitar error
        console.log(data);
        return `
        <div class="modal fade" id="readData" tabindex="-1" aria-labelledby="readDataLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="readDataLabel">Cita Agendada</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="myForm">
                            <div class="inputField">
                                <div>
                                    <label for="namePatient">Paciente: </label>
                                    <p id="namePatient">${data.name || 'Sin paciente'}</p>
                                </div>
                                <div>
                                    <label for="day">Día: </label>
                                    <p id="day">${data.fecha ? new Date(data.fecha).toLocaleDateString() : 'Sin fecha'}</p>
                                </div>
                                <div>
                                    <label for="hour">Hora: </label>
                                    <p id="hour">${data.hora || 'Sin hora'}</p>
                                </div>
                                <div>
                                    <label for="reason">Motivo: </label>
                                    <p id="reason">${data.reason || data.motivo || 'Sin motivo'}</p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>`;
    },

    // Inicializar la app y modal
    init: function () {
        // Renderizar modal en el DOM al abrirlo
        $(document).on('click', '.btn-view', (event) => {
            const index = $(event.currentTarget).data('index');
            const cita = this.currentCitas[index];
            if (cita) {
                // Eliminar modal previo si existe
                $('#readData').remove();

                // Agregar modal al body
                $('body').append(this.renderModal(cita));
                // Llenar modal con datos
                this.fillModal(cita);

                // Mostrar modal (con Bootstrap 5)
                const modal = new bootstrap.Modal(document.getElementById('readData'));
                modal.show();
            }
        });

        // Otras inicializaciones...
        if (this.user.id) {
            this.getLista();
        }
    },

    // Rellena el modal con los datos de la cita seleccionada
    fillModal: function (cita) {
        $('#namePatient').val(cita.name || '');
        const [fecha, hora] = (cita.fecha || '').split(' ');
        $('#day').val(fecha || '');
        $('#hour').val(hora || '');
        $('#reason').val(cita.reason || cita.motivo || '');
    },

    editarCita: function(index) {
    const cita = this.currentCitas[index];
    if (!cita) return alert("No se encontró la cita.");

    // Cargar datos en el formulario
    $('#editarCitaId').val(cita.id);
    // Para la fecha, si viene en formato ISO o similar, corta la parte de la fecha
    let fecha = cita.fecha ? cita.fecha.split(' ')[0] : '';
    $('#editarFecha').val(fecha);
    $('#editarHora').val(cita.hora || '');
    $('#editarMotivo').val(cita.reason || cita.motivo || '');

    // Mostrar modal
    const modal = new bootstrap.Modal(document.getElementById('modalEditarCita'));
    modal.show();


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
            app.getLista(); // Recargar la lista de citas
            bootstrap.Modal.getInstance(document.getElementById("modalEditarCita")).hide();
            // Opcionalmente recarga las citas
            document.getElementById("consulta-cita").dispatchEvent(new Event("submit"));
        } else {
            alert("Hubo un error al actualizar la cita.");
        }
    })
    .catch(err => {
        console.error("Error al editar la cita:", err);
        // alert("Error en la solicitud.");
    });
});
},

    // Render tabla de citas usando forEach
    lista: function (citas) {
        if (!Array.isArray(citas) || citas.length === 0) {
            return '<h2>No hay citas para mostrar</h2>';
        }

        let rows = '';
        console.log('Citas:', citas);
        citas.forEach((cita, index) => {
            const [fecha, hora] = (cita.fecha || '').split(' ');
            rows += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${fecha || 'Sin fecha'}</td>
                    <td>${cita.hora || 'Sin hora'}</td>
                    <td>${cita.name || 'Sin paciente'}</td>
                    <td>
                        <button class="btn btn-success btn-view" data-index="${index}">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-primary" onclick="app.editarCita(${index})"><i class="bi bi-pencil-square"></i></button>
                        <button class="btn btn-primary" onclick="app.completarCita(${cita.id})"><i class="bi bi-check"></i></button>

                        <button class="btn btn-danger" onclick="app.cancelarCita(${cita.id})"><i class="bi bi-trash2-fill"></i></button>
                    </td>
                </tr>
            `;
        });

        return `
            <div class="col-12">
                <table class="table table-striped table-hover mt-3 text-center table-bordered">
                    <thead>
                        <tr>
                            <th>Cita No.</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Paciente</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="data">
                        ${rows}
                    </tbody>
                </table>
            </div>
        `;
    },

    // Carga lista completa de citas
    getLista: async function () {
        try {
            this.$list.html('<h2>Cargando citas...</h2>');
            console.log('User ID:', this.user.id);
            let citas = await $.getJSON(`${this.routes.getlitas}/${this.user.id}`);
            // console.log('Citas raw:', citas);

            // Asegurar que citas sea un arreglo
            if (typeof citas === 'string') {
                citas = JSON.parse(citas);
            }
            if (!Array.isArray(citas) && typeof citas === 'object') {
                citas = citas.data || Object.values(citas);
            }

            this.currentCitas = citas;  // Guardamos las citas para el modal

            const html = this.lista(citas);
            this.$list.html(html);
        } catch (err) {
            console.error(err);
            this.$list.html('<h2>Error al cargar las citas</h2>');
        }
    },

    loadinicio: async function () {
        try {
            let html = '';
            let number = await $.getJSON(this.routes.inicio);
            console.log(number);
            if(number.length > 0) {
                html = this.inicio(number);
            }
            this.$inicio.html(html);
        }catch (err) {
            console.error(err);
        }
    },

    // Alias para cargar citas vía otro endpoint si se desea
    getCitas: async function () {
        try {
            let html = "<h2>Aún no hay citas</h2>";
            this.$lp.html("");
            console.log("User ID:", this.user.id);
            const $citas = await $.getJSON(this.routes.citas + '/' + this.user.id);
            if ($citas.length > 0) {
                html = this.mainPostHTMLBuilder($citas);
            }
            this.$lp.html(html);
        } catch (err) {
            console.error(err);
        }
    },

    completarCita : function (id){
        if (confirm("¿Estás seguro de que deseas completar esta cita?")) {
            fetch(app.routes.completarCita, {
                method: "POST",
                body: JSON.stringify({ id: id}),
            })
            .then(resp => resp.json())
            .then(data => {
                console.log("Respuesta del servidor:", data);
                if (data) {
                    alert("Cita completada correctamente.");
                    app.getLista();
                    // Puedes volver a consultar las citas automáticamente
                    $("#consulta-cita").submit();
                } else {
                    alert("Hubo un error al completar la cita.");
                }
            })
            .catch(err => {
                console.error("Error al completar la cita:", err);
            });
        }
    },

    cancelarCita : function (id) {
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
                app.getLista();
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
};

// Inicializar
$(document).ready(() => {
    app.init();
});
