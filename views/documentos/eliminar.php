<?php
require_once '../../config/database.php';
$id_documento = $_GET['id_documento'] ?? null;

if (!$id_documento) {
    echo "<script>
        alert('ID no válido.');
        window.location.href = 'listar.php';
    </script>";
    exit;
}

echo "<script>
    if (confirm('¿Estás seguro de que deseas eliminar este documento?')) {
        window.location.href = '../../controller/documentoController.php?eliminar_documento=".$id_documento."';
    } else {
        window.location.href = 'listar.php';
    }
</script>";
?>