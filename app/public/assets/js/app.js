const app = {
    routes: {
        home: '/home',
        inisession: '/Session/iniSession',
        login: '/Session/userAuth',
        register: '/Register/register',
        prevpost: '/Posts/getPosts',
        lastpost: '/Posts/lastPost',
        openpost: '/Posts/openPost',
        togglelike: '/Posts/toggleLike',
        togglecomments: '/Posts/getComments',
        savecomment: '/Posts/saveComment',
        citas: '/Citas/getCitas',
        getPacientes: '/Pacientes/getPacientes',
        getlitas: '/Citas/getlista',
    },
    user: {
        sv: false,
        id: '',
        username: '',
        tipo: ''
    },
    $pp: $('#prev-posts'),
    $lp: $('#content'),
    $list: $('#list'),

    currentCitas: [], // Aquí almacenaremos las citas cargadas

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
                                    <p id="hour">${data.fecha ? new Date(data.fecha).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) : 'Sin hora'}</p>
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
                    <td>${hora || 'Sin hora'}</td>
                    <td>${cita.name || 'Sin paciente'}</td>
                    <td>
                        <button class="btn btn-success btn-view" data-index="${index}">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-primary"><i class="bi bi-pencil-square"></i></button>
                        <button class="btn btn-danger"><i class="bi bi-trash2-fill"></i></button>
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
            console.log('Citas raw:', citas);

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
};

// Inicializar
$(document).ready(() => {
    app.init();
});
