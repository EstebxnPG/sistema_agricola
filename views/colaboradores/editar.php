<?php
require_once '../../config/database.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: listar.php");
    exit;
}

// Obtener datos del colaborador
$stmt = $conn->prepare("SELECT * FROM colaborador WHERE id_colaborador = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$colaborador = $result->fetch_assoc();

if (!$colaborador) {
    header("Location: listar.php");
    exit;
}

// Obtener lista de agricultores
$agricultores = $conn->query("SELECT id_agricultor, nombre FROM agricultor ORDER BY nombre");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Colaborador</title>
</head>
<body>
    <h2>Editar Colaborador</h2>

    <form action="../../controller/colaboradorController.php" method="POST">
        <input type="hidden" name="id" value="<?= $colaborador['id_colaborador'] ?>">

        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" value="<?= htmlspecialchars($colaborador['nombre']) ?>" required> <br><br>

        <label for="documento">Documento: </label>
        <input type="text" name="documento" value="<?= htmlspecialchars($colaborador['documento']) ?>" required> <br><br>

        <label for="cargo">Cargo: </label>
        <input type="text" name="cargo" value="<?= htmlspecialchars($colaborador['cargo']) ?>" required> <br><br>

        <label for="contacto">Contacto: </label>
        <input type="number" name="contacto" value="<?= htmlspecialchars($colaborador['contacto']) ?>" required> <br><br>

        <label for="id_agricultor">Agricultor: </label>
        <select name="id_agricultor" required>
            <?php while($agricultor = $agricultores->fetch_assoc()): ?>
                <option value="<?= $agricultor['id_agricultor'] ?>" <?= $agricultor['id_agricultor'] == $colaborador['id_agricultor'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($agricultor['nombre']) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit" name="editar_colaborador">GUARDAR CAMBIOS</button>
    </form>

    <p><a href="listar.php">Volver a la lista</a></p>
</body>
</html>