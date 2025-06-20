<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Herramienta/Maquinaria</title>
</head>
<?php 
    require_once '../../config/database.php';
    // Obtener lista de agricultores
    $agricultores = $conn->query("SELECT id_agricultor, nombre FROM agricultor ORDER BY nombre");
?>
<body>
    <h2>Formulario de Registro de Herramientas y Maquinaria</h2>
    <form action="../../controller/herramientaMaquinariaController.php" method="POST">

        <label for="tipo">Tipo (Herramienta o Maquinaria):</label><br>
        <select name="tipo" id="tipo" required>
                            <option value="">Seleccione...</option>
                            <option value="herramienta">Herramienta</option>
                            <option value="normal">Maquinaria</option>
        </select> <br><br>

        <label for="referencia">Referencia:</label><br>
        <input type="text" id="referencia" name="referencia" required><br><br>

        <label for="estado">Estado:</label><br>
        <select name="estado" id="estado" required>
                            <option value="">Seleccione</option>
                            <option value="malo">Malo</option>
                            <option value="normal">Normal</option>
                            <option value="bueno">Bueno</option>
                            <option value="perfecto">Perfecto</option>
        </select> <br><br>

        <label for="fecha_compra">Fecha Compra:</label><br>
        <input type="date" id="fecha_compra" name="fecha_compra"><br><br>

        <label for="id_agricultor">Agricultor:</label><br>
        <select name="id_agricultor" required>
            <option value="">Seleccione un agricultor</option>
            <?php while($agricultor = $agricultores->fetch_assoc()): ?>
                <option value="<?= $agricultor['id_agricultor'] ?>">
                    <?= htmlspecialchars($agricultor['nombre']) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit" name="registrar_maquinaria">Registrar</button>
    </form>
    <a href="listar.php">Volver</a>
</body>
</html>