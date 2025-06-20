<?php require_once '../../config/database.php'; 
// Obtener lista de agricultores para el select
$agricultores = $conn->query("SELECT id_agricultor, nombre FROM agricultor ORDER BY nombre");
?>

<!-- VIEW - Para el registro de un nuevo colaborador. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Colaborador</title>
</head>
<body>
    <h2>Registrar nuevo Colaborador</h2>

    <form action="../../controller/colaboradorController.php" method="POST">

        <label for="nombre">Nombre: </label>
        <input type="text" name="nombre" required> <br><br>

        <label for="documento">Documento: </label>
        <input type="text" name="documento" required> <br><br>

        <label for="cargo">Cargo: </label>
        <input type="text" name="cargo" required> <br><br>

        <label for="contacto">Contacto: </label>
        <input type="number" name="contacto" required> <br><br>

        <label for="email">Email: </label>
        <input type="email" step="0.01" name="email"><br><br>

        <label for="id_agricultor">Agricultor: </label>
        <select name="id_agricultor" required>
            <option value="">Seleccione un agricultor</option>
            <?php while($agricultor = $agricultores->fetch_assoc()): ?>
                <option value="<?= $agricultor['id_agricultor'] ?>">
                    <?= htmlspecialchars($agricultor['nombre']) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit" name="registrar_colaborador">CREAR</button>
    </form>

    <p><a href="listar.php">Ver Colaboradores</a></p>
</body>
</html>