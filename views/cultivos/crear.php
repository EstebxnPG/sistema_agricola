<?php require_once '../../config/database.php'; 
$agricultores = $conn->query("SELECT id_agricultor, nombre FROM agricultor ORDER BY nombre");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Nuevo Cultivo</title>
    <style>
        .preview-img {
            max-width: 200px;
            max-height: 200px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <h2>Registrar Nuevo Cultivo</h2>

    <form action="../../controller/cultivoController.php" method="POST" enctype="multipart/form-data">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="fecha_siembra">Fecha de Siembra:</label>
        <input type="date" id="fecha_siembra" name="fecha_siembra"><br><br>

        <label for="ubicacion">Ubicación:</label>
        <input type="text" id="ubicacion" name="ubicacion"><br><br>

        <label for="imagen">Fotografía del Cultivo:</label>
        <input type="file" id="imagen" name="imagen" accept="image/*" onchange="previewImage(this)"><br>
        <img id="imagePreview" class="preview-img" style="display:none;"><br><br>

        <label for="id_agricultor">Agricultor:</label>
        <select name="id_agricultor" id="id_agricultor" required>
            <option value="">Seleccione un agricultor</option>
            <?php while($agricultor = $agricultores->fetch_assoc()): ?>
                <option value="<?= $agricultor['id_agricultor'] ?>">
                    <?= htmlspecialchars($agricultor['nombre']) ?>
                </option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit" name="registrar_cultivo">Registrar</button>
    </form>

    <a href="listar.php">Volver a la lista</a>

    <!-- IA - Ayuda, preview de la imagen -->
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