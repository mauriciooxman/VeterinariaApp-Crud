<?php
require_once '../config/database.php';
require_once '../models/Tratamiento.php';
require_once '../models/Cita.php';

$database = new Database();
$db = $database->getConnection();
$tratamiento = new Tratamiento($db);
$cita = new Cita($db);

$edit_mode = false;

// Verificar si es edición
if(isset($_GET['id']) && is_numeric($_GET['id']) && $_GET['id'] > 0) {
    $edit_mode = true;
    $tratamiento->id_tratamiento = intval($_GET['id']);
    $tratamiento->readOne();
}

// Obtener lista de citas para el select
$citas_stmt = $cita->readAll();

// Procesar formulario
if($_POST) {
    $tratamiento->id_cita = $_POST['id_cita'];
    $tratamiento->descripcion = $_POST['descripcion'];
    $tratamiento->medicamentos = $_POST['medicamentos'];
    $tratamiento->costo = $_POST['costo'];

    if($edit_mode) {
        if($tratamiento->update()) {
            header("Location: tratamientos.php");
            exit();
        } else {
            $error = "Error al actualizar el tratamiento";
        }
    } else {
        if($tratamiento->create()) {
            header("Location: tratamientos.php");
            exit();
        } else {
            $error = "Error al crear el tratamiento";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $edit_mode ? 'Editar' : 'Nuevo'; ?> Tratamiento - Sistema Veterinaria</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🐾 <?php echo $edit_mode ? 'Editar' : 'Nuevo'; ?> Tratamiento</h1>
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
                    <label for="id_cita">Cita *</label>
                    <select id="id_cita" name="id_cita" required>
                        <option value="">Seleccione una cita</option>
                        <?php while($row = $citas_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?php echo $row['id_cita']; ?>"
                                <?php echo ($edit_mode && $tratamiento->id_cita == $row['id_cita']) ? 'selected' : ''; ?>>
                                Cita #<?php echo $row['id_cita']; ?> - 
                                <?php echo htmlspecialchars($row['mascota_nombre']); ?> - 
                                <?php echo date('d/m/Y', strtotime($row['fecha_cita'])); ?> - 
                                <?php echo htmlspecialchars($row['motivo']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="descripcion">Descripción del Tratamiento *</label>
                    <textarea id="descripcion" name="descripcion" required><?php echo $edit_mode ? htmlspecialchars($tratamiento->descripcion) : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="medicamentos">Medicamentos</label>
                    <textarea id="medicamentos" name="medicamentos"><?php echo $edit_mode ? htmlspecialchars($tratamiento->medicamentos) : ''; ?></textarea>
                </div>

                <div class="form-group">
                    <label for="costo">Costo</label>
                    <input type="number" id="costo" name="costo" step="0.01" min="0" 
                           value="<?php echo $edit_mode ? $tratamiento->costo : ''; ?>"
                           placeholder="0.00">
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">
                        <?php echo $edit_mode ? 'Actualizar' : 'Crear'; ?>
                    </button>
                    <a href="tratamientos.php" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
