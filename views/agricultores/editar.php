<?php
require_once '../../config/database.php';

// Obtenemos el agricultor 
$id = $_GET['id'] ?? null;

if (!$id) {
    echo "ID no válido.";
    exit;
}

// Traer datos actuales del agricultor
$stmt = $conn->prepare("SELECT * FROM agricultor WHERE id_agricultor = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$agricultor = $result->fetch_assoc();

if (!$agricultor) {
    echo "Agricultor no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Agricultor</title>
</head>
<body>
    <h2>Editar Agricultor</h2>
    <form action="../../controller/agricultorController.php" method="POST">
        <input type="hidden" name="id" value="<?= $agricultor['id_agricultor'] ?>">

        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($agricultor['nombre']) ?>" required><br><br>

        <label for="documento">Documento:</label><br>
        <input type="text" id="documento" name="documento" value="<?= htmlspecialchars($agricultor['documento']) ?>" required><br><br>

        <label for="contacto">Contacto:</label><br>
        <input type="text" id="contacto" name="contacto" value="<?= htmlspecialchars($agricultor['contacto']) ?>"><br><br>

        <label for="email">Correo Electrónico:</label><br>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($agricultor['email']) ?>"><br><br>

        <button type="submit" name="editar_agricultor">Guardar cambios</button>
    </form>
    <a href="listar.php">Volver</a>
</body>
</html>