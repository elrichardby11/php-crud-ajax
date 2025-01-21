# A simple CRUD with PHP, Ajax PL/pgsql and Bootstrap

## Requisitos

- PHP 7.4 o superior
- Composer
- PostgreSQL

## Instalación

1. Clona el repositorio en tu máquina local:
    ```sh
    git clone https://github.com/elrichardby11/php-crud-ajax.git
    cd php-crud-ajax
    ```

2. Instala las dependencias de PHP usando Composer:
    ```sh
    composer install
    ```

3. Crea un archivo `.env` en la raíz del proyecto y configura las variables de entorno para la conexión a la base de datos:
    ```properties
    DB_HOST=tu_host
    DB_DATABASE=tu_base_de_datos
    DB_USERNAME=tu_usuario
    DB_PASSWORD=tu_contraseña
    DB_PORT=5432
    ```

4. Ejecuta el script del repositorio

5. Inicia el servidor web:
    ```sh
    php -S localhost:8000
    ```

6. Abre tu navegador y navega a `http://localhost:8000` para ver la aplicación en funcionamiento.

## Estructura del Proyecto

- `index.php`: Página principal que lista todas las empresas.
- `create.php`: Página para crear una nueva empresa.
- `edit.php`: Página para editar una empresa existente.
- `delete.php`: Script para eliminar una empresa.
- `details.php`: Página para ver los detalles de una empresa.
- `ajaxfile.php`: Script para manejar las solicitudes AJAX.
- `config.php`: Archivo de configuración para la conexión a la base de datos.
- `vendor/`: Carpeta que contiene las dependencias instaladas por Composer.

## Dependencias

- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv): Carga variables de entorno desde un archivo `.env`.

## Demo

### Listado Normal
![image](https://github.com/user-attachments/assets/738515e8-f11a-4039-8580-40ff111eb31a)

### Listado Completo
![image](https://github.com/user-attachments/assets/f98b50de-5946-4759-99d3-7dd78bea4bdc)

### Añadir
![image](https://github.com/user-attachments/assets/d4355e27-9227-4b3c-a475-94c4d1c63943)

### Modificar 
![image](https://github.com/user-attachments/assets/b78f31ed-105c-4c67-8cf2-23150475887b)