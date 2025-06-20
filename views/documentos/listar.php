<?php
require_once '../../config/database.php';

$documentos = $conn->query("SELECT * FROM documento ORDER BY fecha_subida DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Documentos</title>
</head>
<body>
    <h2>Todos los Documentos</h2>
    <a href="crear.php">Subir nuevo documento</a><br><br>
    
    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Tipo</th>
            <th>Nombre del Archivo</th>
            <th>Fecha de Subida</th>
            <th>Acciones</th>
        </tr>
        
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
    </table>
    
    <p><a href="../../index.php">Volver</a></p>
</body>
</html>