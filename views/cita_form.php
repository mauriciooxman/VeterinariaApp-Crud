<?php
require_once '../config/database.php';
require_once '../models/Cita.php';
require_once '../models/Mascota.php';
require_once '../models/Veterinario.php';

$database = new Database();
$db = $database->getConnection();
$cita = new Cita($db);
$mascota = new Mascota($db);
$veterinario = new Veterinario($db);

$edit_mode = false;

// Verificar si es edición
if(isset($_GET['id'])) {
    $edit_mode = true;
    $cita->id_cita = $_GET['id'];
    $cita->readOne();
}

// Obtener listas para los selects
$mascotas_stmt = $mascota->readAll();
$veterinarios_stmt = $veterinario->readAll();

// Procesar formulario
if($_POST) {
    $cita->id_mascota = $_POST['id_mascota'];
    $cita->id_veterinario = $_POST['id_veterinario'];
    $cita->fecha_cita = $_POST['fecha_cita'];
    $cita->motivo = $_POST['motivo'];
    $cita->estado = $_POST['estado'];
    $cita->observaciones = $_POST['observaciones'];

    if($edit_mode) {
        if($cita->update()) {
            header("Location: citas.php");
            exit();
        } else {
            $error = "Error al actualizar la cita";
        }
    } else {
        if($cita->create()) {
            header("Location: citas.php");
            exit();
        } else {
            $error = "Error al crear la cita";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $edit_mode ? 'Editar' : 'Nueva'; ?> Cita - Sistema Veterinaria</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🐾 <?php echo $edit_mode ? 'Editar' : 'Nueva'; ?> Cita</h1>
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
                    <label for="id_mascota">Mascota *</label>
                    <select id="id_mascota" name="id_mascota" required>
                        <option value="">Seleccione una mascota</option>
                        <?php while($row = $mascotas_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?php echo $row['id_mascota']; ?>"
                                <?php echo ($edit_mode && $cita->id_mascota == $row['id_mascota']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($row['nombre'] . ' - ' . $row['especie'] . ' (' . $row['cliente_nombre'] . ' ' . $row['cliente_apellido'] . ')'); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_veterinario">Veterinario *</label>
                    <select id="id_veterinario" name="id_veterinario" required>
                        <option value="">Seleccione un veterinario</option>
                        <?php while($row = $veterinarios_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?php echo $row['id_veterinario']; ?>"
                                <?php echo ($edit_mode && $cita->id_veterinario == $row['id_veterinario']) ? 'selected' : ''; ?>>
                                Dr. <?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apellido']); ?>
                                <?php if($row['especialidad']): ?>
                                    - <?php echo htmlspecialchars($row['especialidad']); ?>
                                <?php endif; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="fecha_cita">Fecha y Hora *</label>
                    <input type="datetime-local" id="fecha_cita" name="fecha_cita" 
                           value="<?php echo $edit_mode ? date('Y-m-d\TH:i', strtotime($cita->fecha_cita)) : ''; ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="motivo">Motivo de la Cita</label>
                    <input type="text" id="motivo" name="motivo" 
                           value="<?php echo $edit_mode ? htmlspecialchars($cita->motivo) : ''; ?>"
                           placeholder="Ej: Consulta de rutina, Vacunación, etc.">
                </div>

                <div class="form-group">
                    <label for="estado">Estado *</label>
                    <select id="estado" name="estado" required>
                        <option value="Pendiente" <?php echo ($edit_mode && $cita->estado == 'Pendiente') ? 'selected' : ''; ?>>Pendiente</option>
                        <option value="Confirmada" <?php echo ($edit_mode && $cita->estado == 'Confirmada') ? 'selected' : ''; ?>>Confirmada</option>
                        <option value="Completada" <?php echo ($edit_mode && $cita->estado == 'Completada') ? 'selected' : ''; ?>>Completada</option>
                        <option value="Cancelada" <?php echo ($edit_mode && $cita->estado == 'Cancelada') ? 'selected' : ''; ?>>Cancelada</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="observaciones">Observaciones</label>
                    <textarea id="observaciones" name="observaciones"><?php echo $edit_mode ? htmlspecialchars($cita->observaciones) : ''; ?></textarea>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">
                        <?php echo $edit_mode ? 'Actualizar' : 'Crear'; ?>
                    </button>
                    <a href="citas.php" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
