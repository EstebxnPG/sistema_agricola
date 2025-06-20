<?php
require_once '../../config/database.php';

$resultado = $conn->query("SELECT c.*, a.nombre as nombre_agricultor 
                          FROM colaborador c 
                          JOIN agricultor a ON c.id_agricultor = a.id_agricultor 
                          ORDER BY c.id_colaborador DESC"); // Sentencia sql ayudo IA
?>

<h2>Lista de Colaboradores</h2>
<a href="crear.php">Agregar nuevo colaborador</a><br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Documento</th>
        <th>Cargo</th>
        <th>Contacto</th>
        <th>Agricultor</th>
        <th>Acciones</th>
    </tr>

    <?php while($colaborador = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?= $colaborador['id_colaborador'] ?></td>
            <td><?= htmlspecialchars($colaborador['nombre']) ?></td>
            <td><?= htmlspecialchars($colaborador['documento']) ?></td>
            <td><?= htmlspecialchars($colaborador['cargo']) ?></td>
            <td><?= htmlspecialchars($colaborador['contacto']) ?></td>
            <td><?= htmlspecialchars($colaborador['nombre_agricultor']). "-" . htmlspecialchars($colaborador['id_agricultor']) ?></td>
            <td>
                <a href="editar.php?id=<?= $colaborador['id_colaborador'] ?>">Editar</a>
                <a href="eliminar.php?id=<?= $colaborador['id_colaborador'] ?>" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
            </td>
        </tr>
    <?php endwhile; ?>
</table>

<p><a href="../../index.php">Volver al inicio</a></p>