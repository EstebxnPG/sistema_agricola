<?php
require_once '../../config/database.php';

$query = "SELECT c.*, a.nombre as agricultor 
          FROM cultivo c 
          LEFT JOIN agricultor a ON c.id_agricultor = a.id_agricultor 
          ORDER BY c.creado_en DESC";
$cultivos = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Cultivos</title>
</head>
<body>
    <h2>Listado de Cultivos</h2>
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
                       onclick="return confirm('¿Está seguro de eliminar este cultivo?')">Eliminar</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    
<p><a href="../../index.php">Volver al inicio</a></p>