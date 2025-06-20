<!-- ver.php, documento visualizarlo  -->
<?php
require_once '../../config/database.php';

$id_documento = $_GET['id_documento'] ?? null;

if (!$id_documento) {
    header("Location: listar.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM documento WHERE id_documento = ?");
$stmt->bind_param("i", $id_documento);
$stmt->execute();
$result = $stmt->get_result();
$documento = $result->fetch_assoc();

if (!$documento) {
    echo "<script>
        alert('Documento no encontrado.');
        window.location.href = 'listar.php';
    </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Documento: <?= htmlspecialchars($documento['nombre_archivo']) ?></title>
    <style>
        .document-container {
            margin: 20px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            max-width: 800px;
        }
        .document-actions {
            margin-top: 20px;
        }
        .document-preview {
            margin-top: 20px;
            border: 1px solid #eee;
            padding: 10px;
            min-height: 300px;
        }
    </style>
</head>
<body>
    <div class="document-container">
        <h2><?= htmlspecialchars($documento['nombre_archivo']) ?></h2>
        
        <div class="document-info">
            <p><strong>Tipo:</strong> <?= ucfirst($documento['tipo_documento']) ?></p>
            <p><strong>Subido el:</strong> <?= $documento['fecha_subida'] ?></p>
        </div>
        
        <div class="document-actions">
            <a href="<?= $documento['ruta_archivo'] ?>" download>Descargar</a> |
            <a href="<?= $documento['ruta_archivo'] ?>" target="_blank">Abrir en nueva pestaña</a> |
            <a href="eliminar.php?id_documento=<?= $documento['id_documento'] ?>">Eliminar</a> |
            <a href="listar.php">Volver a todos los documentos</a>
        </div>
        
        <div class="document-preview">
            <h3>Vista previa:</h3>
            <?php
            $extension = strtolower(pathinfo($documento['nombre_archivo'], PATHINFO_EXTENSION));
            
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                // Mostrar imagen directamente
                echo "<img src='".$documento['ruta_archivo']."' style='max-width: 100%;' alt='Vista previa'>";
            } elseif ($extension == 'pdf') {
                // Mostrar PDF con embed (puede no funcionar en algunos navegadores)
                echo "<embed src='".$documento['ruta_archivo']."' type='application/pdf' width='100%' height='600px'>";
            } elseif (in_array($extension, ['txt', 'csv', 'log'])) {
                // Mostrar contenido de texto plano
                echo "<pre>".htmlspecialchars(file_get_contents($documento['ruta_archivo']))."</pre>";
            } else {
                // Para otros formatos mostrar mensaje
                echo "<p>No hay vista previa disponible para este tipo de archivo.</p>";
                echo "<p><a href='".$documento['ruta_archivo']."' download>Descargar archivo</a> para verlo.</p>";
            }
            ?>
        </div>
    </div>
</body>
</html>