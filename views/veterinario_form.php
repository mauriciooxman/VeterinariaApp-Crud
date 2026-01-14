<?php
require_once '../config/database.php';
require_once '../models/Veterinario.php';

$database = new Database();
$db = $database->getConnection();
$veterinario = new Veterinario($db);

$edit_mode = false;

// Verificar si es edición
if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
    $edit_mode = true;
    $veterinario->id_veterinario = intval($_GET['id']);
    $veterinario->readOne();
}

// Procesar formulario
if($_POST) {
    $veterinario->nombre = $_POST['nombre'];
    $veterinario->apellido = $_POST['apellido'];
    $veterinario->especialidad = $_POST['especialidad'];
    $veterinario->telefono = $_POST['telefono'];
    $veterinario->email = $_POST['email'];
    $veterinario->fecha_contratacion = $_POST['fecha_contratacion'];

    if($edit_mode) {
        if($veterinario->update()) {
            header("Location: veterinarios.php");
            exit();
        } else {
            $error = "Error al actualizar el veterinario";
        }
    } else {
        if($veterinario->create()) {
            header("Location: veterinarios.php");
            exit();
        } else {
            $error = "Error al crear el veterinario";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $edit_mode ? 'Editar' : 'Nuevo'; ?> Veterinario - Sistema Veterinaria</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🐾 <?php echo $edit_mode ? 'Editar' : 'Nuevo'; ?> Veterinario</h1>
        </div>
    </header>

    <nav>
        <ul>
            <li><a href="../index.php">Inicio</a></li>
            <li><a href="clientes.php">Clientes</a></li>
            <li><a href="mascotas.php">Mascotas</a></li>
            <li><a href="veterinarios.php">Veterinarios</a></li>
            <li><a href="citas.php">Citas</a></li>
            <li><a href="tratamientos.php">Tratamientos</a></li>
        </ul>
    </nav>

    <div class="container">
        <?php if(isset($error)): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="form-container">
            <form method="POST">
                <div class="form-group">
                    <label for="nombre">Nombre *</label>
                    <input type="text" id="nombre" name="nombre" 
                           value="<?php echo $edit_mode ? htmlspecialchars($veterinario->nombre) : ''; ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="apellido">Apellido *</label>
                    <input type="text" id="apellido" name="apellido" 
                           value="<?php echo $edit_mode ? htmlspecialchars($veterinario->apellido) : ''; ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="especialidad">Especialidad</label>
                    <input type="text" id="especialidad" name="especialidad" 
                           value="<?php echo $edit_mode ? htmlspecialchars($veterinario->especialidad) : ''; ?>"
                           placeholder="Ej: Cirugía, Medicina General, etc.">
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" 
                           value="<?php echo $edit_mode ? htmlspecialchars($veterinario->telefono) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo $edit_mode ? htmlspecialchars($veterinario->email) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="fecha_contratacion">Fecha de Contratación</label>
                    <input type="date" id="fecha_contratacion" name="fecha_contratacion" 
                           value="<?php echo $edit_mode ? $veterinario->fecha_contratacion : ''; ?>">
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">
                        <?php echo $edit_mode ? 'Actualizar' : 'Crear'; ?>
                    </button>
                    <a href="veterinarios.php" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
