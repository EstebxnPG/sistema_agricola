<?php
require_once '../config/database.php';

// METODO PARA REGISTRAR HERRAMIENTA/MAQUINARIA
if(isset($_POST['registrar_maquinaria'])) {
    $tipo = trim($_POST['tipo']);
    $referencia = trim($_POST['referencia']);
    $estado = trim($_POST['estado']);
    $fecha_compra = trim($_POST['fecha_compra']);
    $id_agricultor = trim($_POST['id_agricultor']); // Añadido para relacionar con agricultor

    // Validación
    if (empty($tipo) || empty($referencia)) {
        echo "<script>
            alert('❌ El tipo y la referencia son obligatorios.');
            window.history.back();
        </script>";
        exit;
    }

    // Insertar datos
    $stmt = $conn->prepare("INSERT INTO herramienta_maquinaria (tipo, referencia, estado, fecha_compra, id_agricultor) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $tipo, $referencia, $estado, $fecha_compra, $id_agricultor);

    if ($stmt->execute()) {
        echo "<script>
            alert('✅ Herramienta/Maquinaria registrada con éxito.');
            window.location.href = '../views/herramientas/listar.php';
        </script>";
    } else {
        echo "<script>
            alert('❌ Error al registrar: " . addslashes($stmt->error) . "');
            window.history.back();
        </script>";
    }

    $stmt->close();
}

// METODO PARA EDITAR HERRAMIENTA/MAQUINARIA
if(isset($_POST['editar_maquinaria'])) {
    $id = $_POST['id'];
    $tipo = trim($_POST['tipo']);
    $referencia = trim($_POST['referencia']);
    $estado = trim($_POST['estado']);
    $fecha_compra = trim($_POST['fecha_compra']);
    $id_agricultor = trim($_POST['id_agricultor']);

    // Validación
    if (empty($tipo) || empty($referencia)) {
        echo "<script>
            alert('❌ El tipo y la referencia son obligatorios.');
            window.history.back();
        </script>";
        exit;
    }

    $stmt = $conn->prepare("UPDATE herramienta_maquinaria SET tipo = ?, referencia = ?, estado = ?, fecha_compra = ?, id_agricultor = ? WHERE id_herramienta = ?");
    $stmt->bind_param("ssssii", $tipo, $referencia, $estado, $fecha_compra, $id_agricultor, $id);

    if ($stmt->execute()) {
        echo "<script>
            alert('✅ Herramienta/Maquinaria actualizada con éxito.');
            window.location.href = '../views/herramientas/listar.php';
        </script>";
    } else {
        echo "<script>
            alert('❌ Error al actualizar: " . addslashes($stmt->error) . "');
            window.history.back();
        </script>";
    }

    $stmt->close();
}

// METODO PARA ELIMINAR HERRAMIENTA/MAQUINARIA
if(isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    
    $stmt = $conn->prepare("DELETE FROM herramienta_maquinaria WHERE id_herramienta = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>
            alert('✅ Herramienta/Maquinaria eliminada con éxito.');
            window.location.href = '../views/herramientas/listar.php';
        </script>";
    } else {
        echo "<script>
            alert('❌ Error al eliminar: " . addslashes($stmt->error) . "');
            window.location.href = '../views/herramientas/listar.php';
        </script>";
    }

    $stmt->close();
}

$conn->close();
?>