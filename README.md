# VeteriarniaApp-Crud

Sistema de gestión para clínica veterinaria con operaciones CRUD completas, desarrollado en PHP y MySQL.

## 📋 Descripción

Aplicación web básica para la gestión integral de una clínica veterinaria que incluye:
- Gestión de clientes (dueños de mascotas)
- Registro de mascotas
- Control de veterinarios y especialidades
- Programación de citas
- Registro de tratamientos

## 🚀 Características

- ✅ **CRUD Completo**: Operaciones de Crear, Leer, Actualizar y Eliminar para todas las entidades
- ✅ **Relaciones en MySQL**: Base de datos con relaciones entre tablas (Foreign Keys)
- ✅ **Interfaz Intuitiva**: Diseño responsive y fácil de usar
- ✅ **Consultas JOIN**: Muestra información relacionada de múltiples tablas
- ✅ **Validación de Datos**: Campos requeridos y tipos de datos validados
- ✅ **Arquitectura MVC**: Separación de modelos, vistas y configuración

## 📁 Estructura del Proyecto

```
VeteriarniaApp-Crud/
├── config/
│   └── database.php          # Configuración de conexión a la BD
├── models/
│   ├── Cliente.php           # Modelo de Clientes
│   ├── Mascota.php           # Modelo de Mascotas
│   ├── Veterinario.php       # Modelo de Veterinarios
│   ├── Cita.php              # Modelo de Citas
│   └── Tratamiento.php       # Modelo de Tratamientos
├── views/
│   ├── clientes.php          # Lista de clientes
│   ├── cliente_form.php      # Formulario de clientes
│   ├── mascotas.php          # Lista de mascotas
│   ├── mascota_form.php      # Formulario de mascotas
│   ├── veterinarios.php      # Lista de veterinarios
│   ├── veterinario_form.php  # Formulario de veterinarios
│   ├── citas.php             # Lista de citas
│   ├── cita_form.php         # Formulario de citas
│   ├── tratamientos.php      # Lista de tratamientos
│   └── tratamiento_form.php  # Formulario de tratamientos
├── css/
│   └── style.css             # Estilos de la aplicación
├── database.sql              # Script de creación de la BD
├── index.php                 # Página principal
└── README.md                 # Este archivo
```

## 🗄️ Base de Datos

### Tablas y Relaciones

1. **clientes** - Información de los dueños de mascotas
2. **mascotas** - Registro de mascotas (relacionada con clientes)
3. **veterinarios** - Personal médico de la clínica
4. **citas** - Programación de consultas (relaciona mascotas y veterinarios)
5. **tratamientos** - Tratamientos realizados (relacionada con citas)

### Diagrama de Relaciones

```
clientes (1) -----> (*) mascotas
mascotas (*) -----> (*) citas
veterinarios (*) --> (*) citas
citas (1) --------> (*) tratamientos
```

## 🔧 Instalación

### Requisitos Previos

- PHP 7.0 o superior
- MySQL 5.7 o superior
- Servidor web (Apache, Nginx, o PHP built-in server)
- Extensión PDO de PHP habilitada

### Pasos de Instalación

1. **Clonar el repositorio**
   ```bash
   git clone https://github.com/mauriciooxman/VeteriarniaApp-Crud.git
   cd VeteriarniaApp-Crud
   ```

2. **Configurar la base de datos**
   
   Crear la base de datos e importar el schema:
   ```bash
   mysql -u root -p < database.sql
   ```
   
   O desde MySQL:
   ```sql
   source database.sql
   ```

3. **Configurar la conexión**
   
   Editar el archivo `config/database.php` con tus credenciales:
   ```php
   private $host = "localhost";
   private $db_name = "veterinaria_db";
   private $username = "tu_usuario";
   private $password = "tu_contraseña";
   ```

4. **Iniciar el servidor**
   
   Usando el servidor incorporado de PHP:
   ```bash
   php -S localhost:8000
   ```
   
   O configurar en Apache/Nginx apuntando al directorio del proyecto.

5. **Acceder a la aplicación**
   
   Abrir el navegador en: `http://localhost:8000`

## 💻 Uso

### Navegación Principal

La aplicación cuenta con un menú de navegación que permite acceder a:
- **Inicio**: Página principal con resumen del sistema
- **Clientes**: Gestión de dueños de mascotas
- **Mascotas**: Registro de animales
- **Veterinarios**: Control del personal médico
- **Citas**: Programación de consultas
- **Tratamientos**: Registro de tratamientos realizados

### Operaciones CRUD

Cada módulo permite:
- **Crear**: Agregar nuevos registros mediante formularios
- **Leer**: Ver listados completos con información relacionada
- **Actualizar**: Editar registros existentes
- **Eliminar**: Borrar registros con confirmación

### Datos de Ejemplo

El script `database.sql` incluye datos de ejemplo para probar el sistema:
- 3 clientes
- 4 mascotas
- 3 veterinarios
- 3 citas
- 2 tratamientos

## 🛠️ Tecnologías Utilizadas

- **Backend**: PHP con PDO
- **Base de Datos**: MySQL
- **Frontend**: HTML5, CSS3
- **Arquitectura**: Modelo-Vista-Controlador (MVC)

## 📝 Características de Seguridad

- Uso de PDO con prepared statements (prevención de SQL injection)
- Sanitización de salida con `htmlspecialchars()`
- Validación de datos en formularios
- Confirmaciones para operaciones de eliminación

## 🤝 Contribuciones

Las contribuciones son bienvenidas. Por favor:
1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📄 Licencia

Este proyecto es de código abierto y está disponible para uso educativo.

## ✨ Autor

Desarrollado como proyecto de demostración de CRUD con PHP y MySQL.

---

**Nota**: Este es un proyecto educativo. Para uso en producción, se recomienda implementar medidas adicionales de seguridad y validación.