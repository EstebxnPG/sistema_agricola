<?php
require_once '../../config/database.php';

// Procesar búsqueda si existe parámetro
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

// Construir consulta SQL con filtro de búsqueda
$query = "SELECT c.*, a.nombre as agricultor, a.email as agricultor_email 
          FROM cultivo c 
          LEFT JOIN agricultor a ON c.id_agricultor = a.id_agricultor 
          WHERE c.nombre LIKE ? OR c.ubicacion LIKE ? OR a.nombre LIKE ?
          ORDER BY c.creado_en DESC";

// Preparar la consulta
$stmt = $conn->prepare($query);

// Si hay búsqueda, agregar parámetros
if (!empty($busqueda)) {
    $param_busqueda = "%$busqueda%";
    $stmt->bind_param("sss", $param_busqueda, $param_busqueda, $param_busqueda);
} else {
    // Si no hay búsqueda, mostrar todos los registros
    $query = "SELECT c.*, a.nombre as agricultor, a.email as agricultor_email 
              FROM cultivo c 
              LEFT JOIN agricultor a ON c.id_agricultor = a.id_agricultor 
              ORDER BY c.creado_en DESC";
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$result = $stmt->get_result();
$cultivos = $result;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Cultivos</title>
</head>
<body>
    <h2>Listado de Cultivos</h2>
    
    <!-- Formulario de búsqueda -->
    <div class="search-container">
        <form method="get" action="">
            <input type="text" name="busqueda" class="search-input" 
                   placeholder="Buscar por nombre, ubicación o agricultor..." 
                   value="<?= htmlspecialchars($busqueda) ?>">
            <button type="submit" class="search-button">Buscar</button>
            
            <?php if(!empty($busqueda)): ?>
                <a href="listar.php" class="clear-search">Limpiar búsqueda</a>
            <?php endif; ?>
        </form>
    </div>

    <a href="crear.php">Nuevo Cultivo</a><br><br>

    <table border="1" cellpadding="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Imagen</th>
                <th>Nombre</th>
                <th>Fecha Siembra</th>
                <th>Ubicación</th>
                <th>Agricultor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if($cultivos->num_rows > 0): ?>
                <?php while($cultivo = $cultivos->fetch_assoc()): ?>
                <tr>
                    <td><?= $cultivo['id_cultivo'] ?></td>
                    <td>
                        <?php if($cultivo['imagen']): ?>
                            <img src="../../uploads/cultivos/<?= $cultivo['imagen'] ?>" class="table-img" width="100">
                        <?php else: ?>
                            Sin imagen
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($cultivo['nombre']) ?></td>
                    <td><?= $cultivo['fecha_siembra'] ?></td>
                    <td><?= htmlspecialchars($cultivo['ubicacion']) ?></td>
                    <td><?= htmlspecialchars($cultivo['agricultor']) ?></td>
                    <td>
                        <a href="editar.php?id=<?= $cultivo['id_cultivo'] ?>">Editar</a> | 
                        <a href="../../controller/cultivoController.php?eliminar=<?= $cultivo['id_cultivo'] ?>" 
                           onclick="return confirm('¿Está seguro de eliminar este cultivo?')">Eliminar</a> |
                        <a href="../../controller/cultivoController.php?notificar=<?= $cultivo['id_cultivo'] ?>" 
                           onclick="return confirm('¿Enviar recordatorio al agricultor?')">Notificar</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">
                        <?= empty($busqueda) ? 'No hay cultivos registrados' : 'No se encontraron resultados' ?>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <p><a href="../../index.php">Volver al inicio</a></p>
</body>
</html>