<?php
    include_once LAYOUTS . 'main_head.php';

    setHeader($d);

?>

    <style>
        /* Sidebar */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    text-decoration: none;
}


.sidebar {
    width: 250px;
    background: #6a1b9a;
    color: white;
    display: flex;
    flex-direction: column;
    padding: 1rem;
    position: fixed;
    height: 100vh;
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

/* Topbar */
.topbar {
    width: calc(100% - 250px);
    margin-left: 250px;
    height: 60px;
    background: white;
    display: flex;
    justify-content: flex-end;
    align-items: center;
    padding: 0 1rem;
    box-shadow: 0 1px 5px rgba(0,0,0,0.1);
    position: fixed;
    top: 0;
    z-index: 10;
}

.topbar .userphoto img {
    height: 40px;
    width: 40px;
    border-radius: 50%;
}

body {
    background: #f4f5fa;
    height: 100%;
    width: 100%;
    position: fixed;
}

section.p-3 {
    margin-left: 250px; /* Ancho de la sidebar */
    margin-top: 70px;    /* Altura de la topbar + algo de espacio */
}

table tr td {
    vertical-align: middle;
}

td button {
    margin: 5px;
}

td button i{
    font-size: 20px;
}

.modal-header {
    background: #0d6efd;
    color: white;

}

.modal-body form {
    display: flex;
    flex-direction: column;
    gap: 1rem; /* espacio entre inputField y footer */
}

/* DELETE this  */
/* .modal-body form .imgHolder {
    flex-basis: 32%;
    height: 100%;
    width: 200px;
    height: 200px;
    position: relative;
    border-radius: 20px;
} */
/* DELETE this */

.modal-body form .inputField {
    border-left: 5px groove blue;
    padding-left: 20px;
    margin-top: 1rem;
}

form .inputField > div {
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

form .inputField > div label {
    font-size: 20px;
    font-weight: 500;

}

#dateForm form .inputField > div label::after {
    content: "*";
    color: red;
}

form .inputField > div input{
    width: 75%;
    padding: 10px;
    border: none;
    outline: none;
    background: transparent;
    border-bottom: 2px solid blue;
}

.modal-footer .sumbit {
    font-size: 18px;
}

#readData form .inputField input > div input {
    color: #000000;
    font-size: 18px;
}
    </style>

    <!-- Title -->
    <h1>Citas Agendadas</h1>
    <!-- End of Title -->

    <!-- Content section -->
    <section class="p-3">

        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#dateForm">Nueva cita <i class="bi bi-calendar-plus"></i></button>
            </div>

            <div class="row content" id="content">

            </div>

        </div>
    </section>
    <!-- End of content section -->

    <!-- Modal Form -->
    <div class="modal fade" id="dateForm">

        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Llena el Formulario</h4>
                    <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <form action="#" id="myForm">
                        <!-- <div class="card imgHolder">
                            <label for="imgInput" class="upload">
                                <input type="file" name="" id="imgInput">
                            </label>
                            <img src="assets/images/profileImageBlank.jpg" alt="profile icon web" height="200px" width="200px">
                        </div> -->

                        <div class="inputField">

                            <div>
                                <label for="nameDoctor">Doctor: </label>
                                <input type="text" name="" id="nameDoctor">
                            </div>

                            <div>
                                <label for="namePatient">Paciente: </label>
                                <input type="text" name="" id="namePatient" placeholder="Nombre del paciente">
                            </div>

                            <div>
                                <label for="day">Día: </label>
                                <input type="date" name="" id="day">
                            </div>

                            <div>
                                <label for="hour">Hora: </label>
                                <input type="text" name="" id="hour">
                            </div>

                            <div>
                                <label for="reason">Motivo: </label>
                                <input type="text" name="" id="reason">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" form="myForm" class="btn btn-primary sumbit">Agendar</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- End of Modal Form -->
    
    <!-- Read Data Modal section -->
    


    <?php

    include_once LAYOUTS . 'main_foot.php';
    setFooter($d);
?>

    <script>
        $( function(){
            app.getLista();
            // app.lastPost();
        })
    </script>

<?php 
    closeFooter();