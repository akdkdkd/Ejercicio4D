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

    // Inserta el HTML del modal en el body
    renderModal: function() {
        return `
        <div class="modal fade" id="readData">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Cita Agendada</h4>
                        <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" id="myForm">
                            <div class="inputField">
                                <div>
                                    <label for="namePatient">Paciente: </label>
                                    <input type="text" id="namePatient" disabled>
                                </div>
                                <div>
                                    <label for="day">Día: </label>
                                    <input type="date" id="day" disabled>
                                </div>
                                <div>
                                    <label for="hour">Hora: </label>
                                    <input type="text" id="hour" disabled>
                                </div>
                                <div>
                                    <label for="reason">Motivo: </label>
                                    <input type="text" id="reason" disabled>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>`;
    },

    // Inicializar la app y modal
    init: function() {
        // Renderizar modal en el DOM
        $('body').append(this.renderModal());

        // Otras inicializaciones...
        if (this.user.id) {
            this.getLista();
        }
    },

    // Render tabla de citas usando forEach
    lista: function(citas) {
        if (!Array.isArray(citas) || citas.length === 0) {
            return '<h2>No hay citas para mostrar</h2>';
        }

        let rows = '';
        citas.forEach((cita, index) => {
            const [fecha, hora] = (cita.fecha || '').split(' ');
            rows += `
                <tr>
                    <td>${index + 1}</td>
                    <td>${cita.doctor || 'Sin doctor'}</td>
                    <td>${fecha || 'Sin fecha'}</td>
                    <td>${hora || 'Sin hora'}</td>
                    <td>${cita.name || 'Sin paciente'}</td>
                    <td>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#readData"><i class="bi bi-eye"></i></button>
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
                            <th>Doctor</th>
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
    getLista: async function() {
        try {
            this.$lp.html('<h2>Cargando citas...</h2>');
            console.log('User ID:', app.user.id);
            let citas = await $.getJSON(`${this.routes.getlitas}/${app.user.id}`);
            console.log('Citas raw:', citas);

            // Asegurar que citas sea un arreglo
            if (typeof citas === 'string') {
                citas = JSON.parse(citas);
            }
            if (!Array.isArray(citas) && typeof citas === 'object') {
                citas = citas.data || Object.values(citas);
            }

            const html = this.lista(citas);
            this.$lp.html(html);
        } catch (err) {
            console.error(err);
            this.$lp.html('<h2>Error al cargar las citas</h2>');
        }
    },

    // Alias para cargar citas vía otro endpoint si se desea
    getCitas: async function() {
        try {
            this.$lp.empty();
            console.log('User ID:', app.user.id);
            let citas = await $.getJSON(`${this.routes.citas}/${app.user.id}`);
            console.log('Citas raw:', citas);

            // Asegurar que citas sea un arreglo
            if (typeof citas === 'string') {
                citas = JSON.parse(citas);
            }
            if (!Array.isArray(citas) && typeof citas === 'object') {
                citas = citas.data || Object.values(citas);
            }

            this.$lp.html(this.lista(citas));
        } catch (err) {
            console.error(err);
            this.$lp.html('<h2>Error al cargar las citas</h2>');
        }
    }
};

// Inicializar
$(document).ready(() => {
    app.init();
});
