<?php
require_once '../../config/database.php';

// Procesar búsqueda
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';

// Construir consulta
$query = "SELECT c.*, a.nombre as nombre_agricultor 
          FROM colaborador c 
          JOIN agricultor a ON c.id_agricultor = a.id_agricultor";

if (!empty($busqueda)) {
    $query .= " WHERE c.nombre LIKE ? OR c.documento LIKE ? OR c.cargo LIKE ? OR c.contacto LIKE ? OR a.nombre LIKE ?";
    $stmt = $conn->prepare($query);
    $param_busqueda = "%$busqueda%";
    $stmt->bind_param("sssss", $param_busqueda, $param_busqueda, $param_busqueda, $param_busqueda, $param_busqueda);
} else {
    $query .= " ORDER BY c.id_colaborador DESC";
    $stmt = $conn->prepare($query);
}

$stmt->execute();
$resultado = $stmt->get_result();
?>

<h2>Lista de Colaboradores</h2>

<!-- Buscador -->
<form method="get" action="">
    <input type="text" name="busqueda" placeholder="Buscar colaboradores..." value="<?= htmlspecialchars($busqueda) ?>">
    <button type="submit">Buscar</button>
    <?php if(!empty($busqueda)): ?>
        <a href="listar.php">Limpiar</a>
    <?php endif; ?>
</form>
<br>

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

    <?php if($resultado->num_rows > 0): ?>
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
    <?php else: ?>
        <tr>
            <td colspan="7"><?= empty($busqueda) ? 'No hay colaboradores' : 'No se encontraron resultados' ?></td>
        </tr>
    <?php endif; ?>
</table>

<p><a href="../../index.php">Volver al inicio</a></p>