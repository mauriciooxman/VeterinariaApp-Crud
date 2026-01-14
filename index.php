<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Veterinaria - CRUD</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🐾 Sistema de Clínica Veterinaria</h1>
            <p>Gestión completa de clientes, mascotas, veterinarios, citas y tratamientos</p>
        </div>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Inicio</a></li>
            <li><a href="views/clientes.php">Clientes</a></li>
            <li><a href="views/mascotas.php">Mascotas</a></li>
            <li><a href="views/veterinarios.php">Veterinarios</a></li>
            <li><a href="views/citas.php">Citas</a></li>
            <li><a href="views/tratamientos.php">Tratamientos</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="card">
            <h2>Bienvenido al Sistema de Gestión Veterinaria</h2>
            <p>Este sistema permite administrar todos los aspectos de una clínica veterinaria:</p>
            <ul style="margin-left: 20px; margin-top: 15px;">
                <li><strong>Clientes:</strong> Gestión de dueños de mascotas con información de contacto.</li>
                <li><strong>Mascotas:</strong> Registro completo de mascotas con relación a sus dueños.</li>
                <li><strong>Veterinarios:</strong> Control del personal médico y sus especialidades.</li>
                <li><strong>Citas:</strong> Programación de consultas entre mascotas y veterinarios.</li>
                <li><strong>Tratamientos:</strong> Registro de tratamientos realizados en cada cita.</li>
            </ul>
        </div>

        <div class="card">
            <h2>Características del Sistema</h2>
            <ul style="margin-left: 20px; margin-top: 15px;">
                <li>✅ Operaciones CRUD completas (Crear, Leer, Actualizar, Eliminar)</li>
                <li>✅ Relaciones entre tablas en MySQL</li>
                <li>✅ Interfaz intuitiva y responsiva</li>
                <li>✅ Validación de datos</li>
                <li>✅ Consultas con JOIN para mostrar información relacionada</li>
            </ul>
        </div>

        <div class="card">
            <h2>Acciones Rápidas</h2>
            <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 15px;">
                <a href="views/cliente_form.php" class="btn btn-primary">Nuevo Cliente</a>
                <a href="views/mascota_form.php" class="btn btn-primary">Nueva Mascota</a>
                <a href="views/veterinario_form.php" class="btn btn-primary">Nuevo Veterinario</a>
                <a href="views/cita_form.php" class="btn btn-success">Nueva Cita</a>
                <a href="views/tratamiento_form.php" class="btn btn-warning">Nuevo Tratamiento</a>
            </div>
        </div>
    </div>

    <footer style="text-align: center; padding: 20px; margin-top: 40px; color: #666;">
        <p>&copy; 2026 Sistema de Clínica Veterinaria - CRUD con MySQL y PHP</p>
    </footer>
</body>
</html>
