<?php
require_once '../config/database.php';
require_once '../models/Tratamiento.php';

$database = new Database();
$db = $database->getConnection();
$tratamiento = new Tratamiento($db);

// Manejar eliminación
if(isset($_GET['delete']) && is_numeric($_GET['delete']) && $_GET['delete'] > 0) {
    $tratamiento->id_tratamiento = intval($_GET['delete']);
    if($tratamiento->delete()) {
        $message = "Tratamiento eliminado exitosamente";
        $message_type = "success";
    } else {
        $message = "Error al eliminar el tratamiento";
        $message_type = "error";
    }
}

$stmt = $tratamiento->readAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tratamientos - Sistema Veterinaria</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🐾 Gestión de Tratamientos</h1>
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
        <?php if(isset($message)): ?>
            <div class="message <?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div style="margin-bottom: 20px;">
            <a href="tratamiento_form.php" class="btn btn-primary">Nuevo Tratamiento</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Mascota</th>
                    <th>Veterinario</th>
                    <th>Descripción</th>
                    <th>Medicamentos</th>
                    <th>Costo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo $row['id_tratamiento']; ?></td>
                        <td><?php echo date('d/m/Y', strtotime($row['fecha_tratamiento'])); ?></td>
                        <td><?php echo htmlspecialchars($row['mascota_nombre']); ?></td>
                        <td><?php echo 'Dr. ' . htmlspecialchars($row['vet_nombre'] . ' ' . $row['vet_apellido']); ?></td>
                        <td><?php echo htmlspecialchars(substr($row['descripcion'], 0, 50)); ?><?php echo strlen($row['descripcion']) > 50 ? '...' : ''; ?></td>
                        <td><?php echo htmlspecialchars(substr($row['medicamentos'], 0, 40)); ?><?php echo strlen($row['medicamentos']) > 40 ? '...' : ''; ?></td>
                        <td>$<?php echo number_format($row['costo'], 2); ?></td>
                        <td class="action-buttons">
                            <a href="tratamiento_form.php?id=<?php echo $row['id_tratamiento']; ?>" class="btn btn-warning">Editar</a>
                            <a href="tratamientos.php?delete=<?php echo $row['id_tratamiento']; ?>" 
                               class="btn btn-danger" 
                               onclick="return confirm('¿Está seguro de eliminar este tratamiento?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
