<?php
require_once '../config/database.php';
require_once '../models/Veterinario.php';

$database = new Database();
$db = $database->getConnection();
$veterinario = new Veterinario($db);

// Manejar eliminación
if(isset($_GET['delete'])) {
    $veterinario->id_veterinario = $_GET['delete'];
    if($veterinario->delete()) {
        $message = "Veterinario eliminado exitosamente";
        $message_type = "success";
    } else {
        $message = "Error al eliminar el veterinario";
        $message_type = "error";
    }
}

$stmt = $veterinario->readAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Veterinarios - Sistema Veterinaria</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🐾 Gestión de Veterinarios</h1>
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
            <a href="veterinario_form.php" class="btn btn-primary">Nuevo Veterinario</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Especialidad</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Fecha Contratación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo $row['id_veterinario']; ?></td>
                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['apellido']); ?></td>
                        <td><?php echo htmlspecialchars($row['especialidad']); ?></td>
                        <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo $row['fecha_contratacion']; ?></td>
                        <td class="action-buttons">
                            <a href="veterinario_form.php?id=<?php echo $row['id_veterinario']; ?>" class="btn btn-warning">Editar</a>
                            <a href="veterinarios.php?delete=<?php echo $row['id_veterinario']; ?>" 
                               class="btn btn-danger" 
                               onclick="return confirm('¿Está seguro de eliminar este veterinario?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
