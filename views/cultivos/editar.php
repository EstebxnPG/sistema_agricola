<?php
require_once '../../config/database.php';

$id = $_GET['id'] ?? null;

if(!$id) {
    header("Location: listar.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM cultivo WHERE id_cultivo = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$cultivo = $result->fetch_assoc();

if(!$cultivo) {
    header("Location: listar.php");
    exit;
}

$agricultores = $conn->query("SELECT id_agricultor, nombre FROM agricultor ORDER BY nombre");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cultivo</title>
    <style>
        .preview-img {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
        }
        .current-img {
            max-width: 200px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <h2>Editar Cultivo</h2>

    <form action="../../controller/cultivoController.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $cultivo['id_cultivo'] ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" value="<?= htmlspecialchars($cultivo['nombre']) ?>" required><br><br>

        <label for="fecha_siembra">Fecha de Siembra:</label>
        <input type="date" id="fecha_siembra" name="fecha_siembra" value="<?= $cultivo['fecha_siembra'] ?>"><br><br>

        <label for="ubicacion">Ubicación:</label>
        <input type="text" id="ubicacion" name="ubicacion" value="<?= htmlspecialchars($cultivo['ubicacion']) ?>"><br><br>

        <label>Imagen actual:</label><br>
        <?php if($cultivo['imagen']): ?>
            <img src="../../uploads/cultivos/<?= $cultivo['imagen'] ?>" class="current-img"><br>
        <?php else: ?>
            <p>No hay imagen</p>
        <?php endif; ?>

        <label for="imagen">Nueva fotografía (dejar en blanco para mantener la actual):</label>
        <input type="file" id="imagen" name="imagen" accept="image/*" onchange="previewImage(this)"><br>
        <img id="imagePreview" class="preview-img" style="display:none;"><br><br>

        <label for="id_agricultor">Agricultor:</label>
        <select name="id_agricultor" id="id_agricultor" required>
            <option value="">Seleccione un agricultor</option>
            <?php while($agricultor = $agricultores->fetch_assoc()): ?>
                <option value="<?= $agricultor['id_agricultor'] ?>" 
                    <?= $agricultor['id_agricultor'] == $cultivo['id_agricultor'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($agricultor['nombre']) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit" name="editar_cultivo">Guardar Cambios</button>
    </form>

    <a href="listar.php">Volver a la lista</a>

    <!-- IA - Ayuda, Ayuda para mostrar un preview de la imagen-->
    <script>
        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            const file = input.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }

            if (file) {
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>