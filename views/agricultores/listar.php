<?php
require_once '../../config/database.php';

// Procesar búsqueda si existe parámetro
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

// Construir consulta base
$query = "SELECT * FROM agricultor";

// Si hay búsqueda, agregar condiciones WHERE
if (!empty($busqueda)) {
    $query .= " WHERE nombre LIKE ? OR documento LIKE ? OR contacto LIKE ? OR email LIKE ?";
    $stmt = $conn->prepare($query);
    $param_busqueda = "%$busqueda%";
    $stmt->bind_param("ssss", $param_busqueda, $param_busqueda, $param_busqueda, $param_busqueda);
} else {
    $query .= " ORDER BY id_agricultor DESC";
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Agricultores</title>
</head>
<body>
    <h2>Lista de Agricultores</h2>
    
    <!-- Formulario de búsqueda -->
    <div class="search-container">
        <form method="get" action="">
            <input type="text" name="busqueda" class="search-input" 
                   placeholder="Buscar agricultores..." 
                   value="<?= htmlspecialchars($busqueda) ?>">
            <button type="submit" class="search-button">Buscar</button>
            
            <?php if(!empty($busqueda)): ?>
                <a href="listar.php" class="clear-search">Limpiar búsqueda</a>
            <?php endif; ?>
        </form>
    </div>

    <a href="crear.php">Agregar nuevo Agricultor</a><br><br>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Documento</th>
                <th>Contacto</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if($resultado->num_rows > 0): ?>
                <?php while($agricultor = $resultado->fetch_assoc()): ?>
                <tr>
                    <td><?= $agricultor['id_agricultor'] ?></td>
                    <td><?= htmlspecialchars($agricultor['nombre']) ?></td>
                    <td><?= htmlspecialchars($agricultor['documento']) ?></td>
                    <td><?= htmlspecialchars($agricultor['contacto']) ?></td>
                    <td><?= htmlspecialchars($agricultor['email']) ?></td>
                    <td class="actions">
                        <a href="editar.php?id=<?= $agricultor['id_agricultor'] ?>">Editar</a>
                        <a href="eliminar.php?id=<?= $agricultor['id_agricultor'] ?>" 
                           onclick="return confirm('¿Está seguro de eliminar este agricultor?')">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">
                        <?= empty($busqueda) ? 'No hay agricultores registrados' : 'No se encontraron resultados' ?>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <p><a href="../../index.php">Volver al inicio</a></p>
</body>
</html>