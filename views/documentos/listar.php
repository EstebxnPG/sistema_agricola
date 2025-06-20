<?php
require_once '../../config/database.php';

// Procesar búsqueda
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

// Construir consulta
$query = "SELECT * FROM documento";

if (!empty($busqueda)) {
    $query .= " WHERE tipo_documento LIKE ? OR nombre_archivo LIKE ?";
    $stmt = $conn->prepare($query);
    $param_busqueda = "%$busqueda%";
    $stmt->bind_param("ss", $param_busqueda, $param_busqueda);
} else {
    $query .= " ORDER BY fecha_subida DESC";
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$documentos = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Documentos</title>
</head>
<body>
    <h2>Todos los Documentos</h2>

    <!-- Buscador -->
    <form method="get" action="">
        <input type="text" name="busqueda" placeholder="Buscar documentos..." value="<?= htmlspecialchars($busqueda) ?>">
        <button type="submit">Buscar</button>
        <?php if(!empty($busqueda)): ?>
            <a href="listar.php">Limpiar</a>
        <?php endif; ?>
    </form>
    <br>

    <a href="crear.php">Subir nuevo documento</a><br><br>
    
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Nombre del Archivo</th>
            <th>Fecha de Subida</th>
            <th>Acciones</th>
        </tr>
        
        <?php if($documentos->num_rows > 0): ?>
            <?php while($doc = $documentos->fetch_assoc()): ?>
            <tr>
                <td><?= $doc['id_documento'] ?></td>
                <td><?= ucfirst($doc['tipo_documento']) ?></td>
                <td><?= htmlspecialchars($doc['nombre_archivo']) ?></td>
                <td><?= $doc['fecha_subida'] ?></td>
                <td>
                    <a href="ver.php?id_documento=<?= $doc['id_documento'] ?>">Ver</a> |
                    <a href="eliminar.php?id_documento=<?= $doc['id_documento'] ?>">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5"><?= empty($busqueda) ? 'No hay documentos' : 'No se encontraron resultados' ?></td>
            </tr>
        <?php endif; ?>
    </table>
    
    <p><a href="../../index.php">Volver</a></p>
</body>
</html>