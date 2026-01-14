<?php
require_once '../config/database.php';
require_once '../models/Mascota.php';

$database = new Database();
$db = $database->getConnection();
$mascota = new Mascota($db);

// Manejar eliminación
if(isset($_GET['delete'])) {
    $mascota->id_mascota = $_GET['delete'];
    if($mascota->delete()) {
        $message = "Mascota eliminada exitosamente";
        $message_type = "success";
    } else {
        $message = "Error al eliminar la mascota";
        $message_type = "error";
    }
}

$stmt = $mascota->readAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mascotas - Sistema Veterinaria</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🐾 Gestión de Mascotas</h1>
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
            <a href="mascota_form.php" class="btn btn-primary">Nueva Mascota</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Especie</th>
                    <th>Raza</th>
                    <th>Edad</th>
                    <th>Peso (kg)</th>
                    <th>Dueño</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo $row['id_mascota']; ?></td>
                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['especie']); ?></td>
                        <td><?php echo htmlspecialchars($row['raza']); ?></td>
                        <td><?php echo $row['edad']; ?> años</td>
                        <td><?php echo $row['peso']; ?></td>
                        <td><?php echo htmlspecialchars($row['cliente_nombre'] . ' ' . $row['cliente_apellido']); ?></td>
                        <td class="action-buttons">
                            <a href="mascota_form.php?id=<?php echo $row['id_mascota']; ?>" class="btn btn-warning">Editar</a>
                            <a href="mascotas.php?delete=<?php echo $row['id_mascota']; ?>" 
                               class="btn btn-danger" 
                               onclick="return confirm('¿Está seguro de eliminar esta mascota?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
