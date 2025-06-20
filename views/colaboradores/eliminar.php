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

// Verificar si existe el colaborador
$stmt = $conn->prepare("SELECT id_colaborador FROM colaborador WHERE id_colaborador = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<script>
        alert('Colaborador no encontrado');
        window.location.href = 'listar.php';
    </script>";
    exit;
}

// Redirigir al controlador para eliminar
echo "<script>
    if (confirm('¿Estás seguro de eliminar este colaborador?')) {
        window.location.href = '../../controller/colaboradorController.php?eliminar=".$id."';
    } else {
        window.location.href = 'listar.php';
    }
</script>";