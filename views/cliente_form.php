<?php
require_once '../config/database.php';
require_once '../models/Cliente.php';

$database = new Database();
$db = $database->getConnection();
$cliente = new Cliente($db);

$edit_mode = false;

// Verificar si es edición
if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
    $edit_mode = true;
    $cliente->id_cliente = intval($_GET['id']);
    $cliente->readOne();
}

// Procesar formulario
if($_POST) {
    $cliente->nombre = $_POST['nombre'];
    $cliente->apellido = $_POST['apellido'];
    $cliente->telefono = $_POST['telefono'];
    $cliente->email = $_POST['email'];
    $cliente->direccion = $_POST['direccion'];

    if($edit_mode) {
        if($cliente->update()) {
            header("Location: clientes.php");
            exit();
        } else {
            $error = "Error al actualizar el cliente";
        }
    } else {
        if($cliente->create()) {
            header("Location: clientes.php");
            exit();
        } else {
            $error = "Error al crear el cliente";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $edit_mode ? 'Editar' : 'Nuevo'; ?> Cliente - Sistema Veterinaria</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🐾 <?php echo $edit_mode ? 'Editar' : 'Nuevo'; ?> Cliente</h1>
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
                           value="<?php echo $edit_mode ? htmlspecialchars($cliente->nombre) : ''; ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="apellido">Apellido *</label>
                    <input type="text" id="apellido" name="apellido" 
                           value="<?php echo $edit_mode ? htmlspecialchars($cliente->apellido) : ''; ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" id="telefono" name="telefono" 
                           value="<?php echo $edit_mode ? htmlspecialchars($cliente->telefono) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo $edit_mode ? htmlspecialchars($cliente->email) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="direccion">Dirección</label>
                    <textarea id="direccion" name="direccion"><?php echo $edit_mode ? htmlspecialchars($cliente->direccion) : ''; ?></textarea>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">
                        <?php echo $edit_mode ? 'Actualizar' : 'Crear'; ?>
                    </button>
                    <a href="clientes.php" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
