<?php
require_once '../../config/database.php';

$resultado = $conn->query("SELECT h.*, a.nombre as nombre_agricultor 
                          FROM herramienta_maquinaria h 
                          JOIN agricultor a ON h.id_agricultor = a.id_agricultor 
                          ORDER BY h.id_herramienta DESC");
?>

<h2>Lista de Herramientas y Maquinaria</h2>
<a href="crear.php">Agregar nueva herramienta/maquinaria</a><br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Tipo</th>
        <th>Referencia</th>
        <th>Estado</th>
        <th>Fecha Compra</th>
        <th>Agricultor</th>
        <th>Acciones</th>
    </tr>

    <?php while($herramienta = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?= $herramienta['id_herramienta'] ?></td>
            <td><?= htmlspecialchars($herramienta['tipo']) ?></td>
            <td><?= htmlspecialchars($herramienta['referencia']) ?></td>
            <td><?= htmlspecialchars($herramienta['estado']) ?></td>
            <td><?= $herramienta['fecha_compra'] ? date('d/m/Y', strtotime($herramienta['fecha_compra'])) : 'No especificada' ?></td>
            <td><?= htmlspecialchars($herramienta['nombre_agricultor']) ?></td>
            <td>
                <a href="editar.php?id=<?= $herramienta['id_herramienta'] ?>">Editar</a>
                <a href="eliminar.php?id=<?= $herramienta['id_herramienta'] ?>" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<p><a href="../../index.php">Volver al inicio</a></p>