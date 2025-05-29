# 🏥 Proyecto Consultorio Médico

## 1. Descripción del Proyecto y su Objetivo

Este proyecto es una aplicación para la gestión de un consultorio médico.  
Su objetivo principal es facilitar el registro de pacientes, la programación de citas, el control de historial médico y la administración general del consultorio.  
Está diseñado para ser intuitivo, eficiente y fácilmente extensible para distintos tipos de prácticas médicas.

---

## 2. Instrucciones para Instalar y Ejecutar el Proyecto

### Requisitos

- Base de datos: MySQL / SQLite / PostgreSQL
- PHP
- Servidor web (Apache)

### Pasos para instalar

1. Clonar el repositorio y entrar al proyecto:
    ```bash
    git clone https://github.com/JadeMajestyX/Ejercicio4D.git
    cd consultorio-medico
    ```

2. Importar la base de datos:
    - Crear una base de datos llamada `consultorio`.
    - Abrir el archivo `consultorio.sql` y ejecutarlo en tu gestor de base de datos.
    - Verificar que las tablas se hayan creado correctamente.

3. Configurar un VirtualHost en Apache:

    Agrega la siguiente configuración en el archivo de VirtualHost:

    ```apache
    <VirtualHost *:80>
        ServerName consultorio.de
        DocumentRoot "C:/ruta/del/proyecto/public"

        <Directory "C:/ruta/del/proyecto/public">
            AllowOverride All
            Require all granted
        </Directory>
    </VirtualHost>
    ```

    Añade esta línea a tu archivo `hosts` (normalmente en `C:\Windows\System32\drivers\etc\hosts` en Windows o `/etc/hosts` en Linux/Mac):

    ```
    127.0.0.1 consultorio.de
    ```

4. Reinicia Apache y abre en el navegador:

    ```
    http://consultorio.de
    ```

---

## 3. Estructura del Proyecto

consultorio/
│
└── app/ # Contiene todos los archivos del proyecto
├── classes/ # Clases bases del framework
├── controllers/ # Controladores encargados de la lógica del negocio
├── Models/ # Archivos que controlan los datos
├── public/ # Archivos accesibles públicamente (index.php, recursos estáticos)
├── resources/ # Plantillas utilizadas para la aplicación
│
├── app.php # Archivo principal que inicializa y ejecuta la aplicación
└── config.php # Configuración global (variables de entorno, base de datos, rutas)
---
