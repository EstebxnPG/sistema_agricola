<?php
require_once '../../config/database.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: listar.php");
    exit;
}

// Obtener datos de la herramienta/maquinaria
$stmt = $conn->prepare("SELECT * FROM herramienta_maquinaria WHERE id_herramienta = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$herramienta = $result->fetch_assoc();

if (!$herramienta) {
    header("Location: listar.php");
    exit;
}

// Obtener lista de agricultores
$agricultores = $conn->query("SELECT id_agricultor, nombre FROM agricultor ORDER BY nombre");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Herramienta/Maquinaria</title>
</head>
<body>
    <h2>Editar Herramienta/Maquinaria</h2>
    <form action="../../controller/herramientaMaquinariaController.php" method="POST">
        <input type="hidden" name="id" value="<?= $herramienta['id_herramienta'] ?>">

        <label for="tipo">Tipo:</label><br>
        <input type="text" id="tipo" name="tipo" value="<?= htmlspecialchars($herramienta['tipo']) ?>" required><br><br>

        <label for="referencia">Referencia:</label><br>
        <input type="text" id="referencia" name="referencia" value="<?= htmlspecialchars($herramienta['referencia']) ?>" required><br><br>

        <label for="estado">Estado:</label><br>
        <input type="text" id="estado" name="estado" value="<?= htmlspecialchars($herramienta['estado']) ?>"><br><br>

        <label for="fecha_compra">Fecha Compra:</label><br>
        <input type="date" id="fecha_compra" name="fecha_compra" value="<?= htmlspecialchars($herramienta['fecha_compra']) ?>"><br><br>

        <label for="id_agricultor">Agricultor:</label><br>
        <select name="id_agricultor" required>
            <?php while($agricultor = $agricultores->fetch_assoc()): ?>
                <option value="<?= $agricultor['id_agricultor'] ?>" <?= $agricultor['id_agricultor'] == $herramienta['id_agricultor'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($agricultor['nombre']) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit" name="editar_maquinaria">Guardar Cambios</button>
    </form>
    <a href="listar.php">Volver</a>
</body>
</html>