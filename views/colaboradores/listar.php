<?php

require_once '../../config/database.php';

echo "funcionando!";

$resultado = $conn->query("SELECT * FROM colaborador ORDER BY id_agricultor DESC");

?>

<h2>Lista de Colaboradores</h2>
<a href="crear.php">Agregar nuevo colaborador</a><br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>ID:</th>
        <th>Nombre</th>
        <th>Documento</th>
        <th>Cargo</th>
        <th>contacto</th>
    </tr>

    <?php while($agricultor = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?= $agricultor['id_agricultor'] ?></td>
            <td><?= htmlspecialchars($agricultor['nombre']) ?></td>
            <td><?= $agricultor['documeno'] ?></td>
            <td><?= $agricultor['cargo'] ?></td>
            <td><?= $agricultor['contacto']  ?></td>
            <td>
                <a href="editar.php?id=<?= $producto['id'] ?>">Editar</a>
                <a href="eliminar.php?id=<?= $producto['id'] ?>">Eliminar</a>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

<p><a href="../dashboard.php">Volver al inicio</a></p>