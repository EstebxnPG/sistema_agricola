<?php
require_once '../../config/database.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<script>
        alert('ID no válido.');
        window.location.href = 'listar.php';
    </script>";
    exit;
}

// Verificar si el agricultor existe antes de eliminar
$stmt = $conn->prepare("SELECT id_agricultor FROM agricultor WHERE id_agricultor = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>
        alert('Agricultor no encontrado.');
        window.location.href = 'listar.php';
    </script>";
    exit;
}

// Redirigir al controlador para eliminar
echo "<script>
    if (confirm('¿Estás seguro de que deseas eliminar este agricultor?')) {
        window.location.href = '../../controller/agricultorController.php?eliminar=".$id."';
    } else {
        window.location.href = 'listar.php';
    }
</script>";
?>