<?php
require_once '../config/database.php';
require_once '../models/Mascota.php';
require_once '../models/Cliente.php';

$database = new Database();
$db = $database->getConnection();
$mascota = new Mascota($db);
$cliente = new Cliente($db);

$edit_mode = false;

// Verificar si es edición
if(isset($_GET['id'])) {
    $edit_mode = true;
    $mascota->id_mascota = $_GET['id'];
    $mascota->readOne();
}

// Obtener lista de clientes para el select
$clientes_stmt = $cliente->readAll();

// Procesar formulario
if($_POST) {
    $mascota->nombre = $_POST['nombre'];
    $mascota->especie = $_POST['especie'];
    $mascota->raza = $_POST['raza'];
    $mascota->edad = $_POST['edad'];
    $mascota->peso = $_POST['peso'];
    $mascota->id_cliente = $_POST['id_cliente'];

    if($edit_mode) {
        if($mascota->update()) {
            header("Location: mascotas.php");
            exit();
        } else {
            $error = "Error al actualizar la mascota";
        }
    } else {
        if($mascota->create()) {
            header("Location: mascotas.php");
            exit();
        } else {
            $error = "Error al crear la mascota";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $edit_mode ? 'Editar' : 'Nueva'; ?> Mascota - Sistema Veterinaria</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>🐾 <?php echo $edit_mode ? 'Editar' : 'Nueva'; ?> Mascota</h1>
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
                           value="<?php echo $edit_mode ? htmlspecialchars($mascota->nombre) : ''; ?>" 
                           required>
                </div>

                <div class="form-group">
                    <label for="especie">Especie *</label>
                    <input type="text" id="especie" name="especie" 
                           value="<?php echo $edit_mode ? htmlspecialchars($mascota->especie) : ''; ?>" 
                           placeholder="Ej: Perro, Gato, Ave, etc."
                           required>
                </div>

                <div class="form-group">
                    <label for="raza">Raza</label>
                    <input type="text" id="raza" name="raza" 
                           value="<?php echo $edit_mode ? htmlspecialchars($mascota->raza) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="edad">Edad (años)</label>
                    <input type="number" id="edad" name="edad" min="0" 
                           value="<?php echo $edit_mode ? $mascota->edad : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="peso">Peso (kg)</label>
                    <input type="number" id="peso" name="peso" step="0.01" min="0" 
                           value="<?php echo $edit_mode ? $mascota->peso : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="id_cliente">Dueño *</label>
                    <select id="id_cliente" name="id_cliente" required>
                        <option value="">Seleccione un cliente</option>
                        <?php while($row = $clientes_stmt->fetch(PDO::FETCH_ASSOC)): ?>
                            <option value="<?php echo $row['id_cliente']; ?>"
                                <?php echo ($edit_mode && $mascota->id_cliente == $row['id_cliente']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($row['nombre'] . ' ' . $row['apellido']); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div style="display: flex; gap: 10px;">
                    <button type="submit" class="btn btn-success">
                        <?php echo $edit_mode ? 'Actualizar' : 'Crear'; ?>
                    </button>
                    <a href="mascotas.php" class="btn btn-danger">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
