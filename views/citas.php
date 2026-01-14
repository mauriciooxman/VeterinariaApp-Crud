<?php
require_once '../config/database.php';
require_once '../models/Cita.php';

$database = new Database();
$db = $database->getConnection();
$cita = new Cita($db);

// Manejar eliminación
if(isset($_GET['delete'])) {
    $cita->id_cita = $_GET['delete'];
    if($cita->delete()) {
        $message = "Cita eliminada exitosamente";
        $message_type = "success";
    } else {
        $message = "Error al eliminar la cita";
        $message_type = "error";
    }
}

$stmt = $cita->readAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Citas - Sistema Veterinaria</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🐾 Gestión de Citas</h1>
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
            <a href="cita_form.php" class="btn btn-primary">Nueva Cita</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Fecha y Hora</th>
                    <th>Mascota</th>
                    <th>Cliente</th>
                    <th>Veterinario</th>
                    <th>Motivo</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo $row['id_cita']; ?></td>
                        <td><?php echo date('d/m/Y H:i', strtotime($row['fecha_cita'])); ?></td>
                        <td><?php echo htmlspecialchars($row['mascota_nombre']) . ' (' . htmlspecialchars($row['especie']) . ')'; ?></td>
                        <td><?php echo htmlspecialchars($row['cliente_nombre'] . ' ' . $row['cliente_apellido']); ?></td>
                        <td><?php echo 'Dr. ' . htmlspecialchars($row['vet_nombre'] . ' ' . $row['vet_apellido']); ?></td>
                        <td><?php echo htmlspecialchars($row['motivo']); ?></td>
                        <td>
                            <span style="padding: 5px 10px; border-radius: 5px; 
                                         background-color: <?php 
                                         echo $row['estado'] == 'Pendiente' ? '#ffc107' : 
                                              ($row['estado'] == 'Confirmada' ? '#28a745' : '#dc3545'); 
                                         ?>; color: white;">
                                <?php echo htmlspecialchars($row['estado']); ?>
                            </span>
                        </td>
                        <td class="action-buttons">
                            <a href="cita_form.php?id=<?php echo $row['id_cita']; ?>" class="btn btn-warning">Editar</a>
                            <a href="citas.php?delete=<?php echo $row['id_cita']; ?>" 
                               class="btn btn-danger" 
                               onclick="return confirm('¿Está seguro de eliminar esta cita?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
