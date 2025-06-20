<?php

require_once '../../config/database.php';

echo "funcionando!";

$resultado = $conn->query("SELECT * FROM agricultor ORDER BY id_agricultor DESC");

?>

<h2>Lista de Agricultor</h2>
<a href="crear.php">Agregar nuevo Agricultor</a><br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>ID:</th>
        <th>Nombre</th>
        <th>Documento</th>
        <th>contacto</th>
        <th>email</th>
    </tr>

    <?php while($agricultor = $resultado->fetch_assoc()): ?>
        <tr>
            <td><?= $agricultor['id_agricultor'] ?></td>
            <td><?= htmlspecialchars($agricultor['nombre']) ?></td>
            <td><?= $agricultor['documento'] ?></td>
            <td><?= $agricultor['contacto']  ?></td>
            <td><?= $agricultor['email'] ?></td>
            <td>
                <a href="editar.php?id=<?= $producto['id'] ?>">Editar</a>
                <a href="eliminar.php?id=<?= $producto['id'] ?>">Eliminar</a>
            </td>
        </tr>
    <?php endwhile; ?>

</table>

<p><a href="../../index.php">Volver al inicio</a></p>