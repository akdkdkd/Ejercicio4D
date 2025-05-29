🏥 Proyecto Consultorio Médico
1. Descripción del Proyecto y su Objetivo
Este proyecto es una aplicación para la gestión de un consultorio médico. Su objetivo principal es facilitar el registro de pacientes, la programación de citas, el control de historial médico y la administración general del consultorio. Está diseñado para ser intuitivo, eficiente y fácilmente extensible para distintos tipos de prácticas médicas.

2. Instrucciones para Instalar y Ejecutar el Proyecto
### Requisitos
- [Base de datos MySQL / SQLite / PostgreSQL]
- PHP
- Servidor web (Apache)

### Pasos para instalar
  1. Clonar el repositorio
    git clone https://github.com/JadeMajestyX/Ejercicio4D.git
    cd consultorio-medico

  3. Importar la base de datos
     - Crear una base de datos llamada consultorio
     - Abrir el archivo consultorio.sql y ejecutarlo en un gestor de base de datos
     - Revisar que las tablas fueron creadas correctamente
    
  4. Configurar un VirtualHost en Apache
     - Abrir el archivo de configuracion de VirtualHost:
       <VirtualHost *:80>
          ServerName consultorio.de
          DocumentRoot "C:/ruta/del/proyecto/public"
      
          <Directory "C:/ruta/del/proyecto/public">
              AllowOverride All
              Require all granted
          </Directory>
      </VirtualHost>

     - Añadir consultorio.de a host:
       127.0.0.1 consultorio.local

     - Reiniciar Apache y abrir el proyecto en el navegador
        http://consultorio.de

   5. Estructura del proyrcto:
      consultorio/
      │
      └── app/                   # Contiene todos los archivos del proyecto
          ├── classes/           # Clases bases del framework
          ├── controllers/       # Contiene los controladores encargados de la logica del negocio
          ├── Models/            # Contiene los archivos que controlan los datos
          ├── public/            # Contiene los archivos accesibles publicamente por el navegador, contiene index.php y recursos estáticos
          ├── resources/         # Contiene las plantillas utilizadas para la aplicación
          │
          ├── app.php            # Archivo pincipal que inicializa y ejecuta la aplicación
          └── config.php         # COnfiguración global con variables para el entorno, base de datos y rutas del proyecto

      


