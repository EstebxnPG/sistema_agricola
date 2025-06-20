<?php
require_once '../../config/database.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<script>
        alert('ID no válido');
        window.location.href = 'listar.php';
    </script>";
    exit;
}

// Verificar si existe la herramienta/maquinaria
$stmt = $conn->prepare("SELECT id_herramienta FROM herramienta_maquinaria WHERE id_herramienta = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>
        alert('Herramienta/Maquinaria no encontrada');
        window.location.href = 'listar.php';
    </script>";
    exit;
}

// Redirigir al controlador para eliminar
echo "<script>
    if (confirm('¿Estás seguro de eliminar esta herramienta/maquinaria?')) {
        window.location.href = '../../controller/herramientaMaquinariaController.php?eliminar=".$id."';
    } else {
        window.location.href = 'listar.php';
    }
</script>";