<?php
require_once '../config/database.php';
require_once '../models/Cliente.php';

$database = new Database();
$db = $database->getConnection();
$cliente = new Cliente($db);

// Manejar eliminación
if(isset($_GET['delete']) && is_numeric($_GET['delete']) && $_GET['delete'] > 0) {
    $cliente->id_cliente = intval($_GET['delete']);
    if($cliente->delete()) {
        $message = "Cliente eliminado exitosamente";
        $message_type = "success";
    } else {
        $message = "Error al eliminar el cliente";
        $message_type = "error";
    }
}

$stmt = $cliente->readAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Sistema Veterinaria</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🐾 Gestión de Clientes</h1>
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
            <a href="cliente_form.php" class="btn btn-primary">Nuevo Cliente</a>
        </div>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Dirección</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo $row['id_cliente']; ?></td>
                        <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($row['apellido']); ?></td>
                        <td><?php echo htmlspecialchars($row['telefono']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['direccion']); ?></td>
                        <td class="action-buttons">
                            <a href="cliente_form.php?id=<?php echo $row['id_cliente']; ?>" class="btn btn-warning">Editar</a>
                            <a href="clientes.php?delete=<?php echo $row['id_cliente']; ?>" 
                               class="btn btn-danger" 
                               onclick="return confirm('¿Está seguro de eliminar este cliente?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
