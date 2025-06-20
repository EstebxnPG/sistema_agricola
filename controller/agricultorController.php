<?php
require_once '../config/database.php';

// METODO PARA REGISTRAR UN AGRICULTOR
if(isset($_POST['registrar_agricultor'])) {
    $nombre = trim($_POST['nombre']);
    $documento = trim($_POST['documento']);
    $contacto = trim($_POST['contacto']);
    $email = trim($_POST['email']);

    // Validación simple
    if (empty($nombre) || empty($documento)) {
        echo "❌ El nombre y el documento son obligatorios.";
        exit;
    }

    // Insertar datos
    $stmt = $conn->prepare("INSERT INTO agricultor (nombre, documento, contacto, email) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $documento, $contacto, $email);

    if ($stmt->execute()) {
        echo "<script>
            alert('✅ Agricultor registrado con éxito.');
            window.location.href = '../views/agricultores/listar.php';
        </script>";
    } else {
        echo "❌ Error al registrar: " . $stmt->error;
    }

    $stmt->close();
}

// METODO PARA EDITAR UN AGRICULTOR
if(isset($_POST['editar_agricultor'])) {
    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $documento = trim($_POST['documento']);
    $contacto = trim($_POST['contacto']);
    $email = trim($_POST['email']);

    // Validación
    if (empty($nombre) || empty($documento)) {
        echo "❌ El nombre y el documento son obligatorios.";
        exit;
    }

    $stmt = $conn->prepare("UPDATE agricultor SET nombre = ?, documento = ?, contacto = ?, email = ? WHERE id_agricultor = ?");
    $stmt->bind_param("ssssi", $nombre, $documento, $contacto, $email, $id);

    if ($stmt->execute()) {
        echo "<script>
            alert('✅ Agricultor actualizado con éxito.');
            window.location.href = '../views/agricultores/listar.php';
        </script>";
    } else {
        echo "❌ Error al actualizar: " . $stmt->error;
    }

    $stmt->close();
}


// METODO PARA ELIMINAR UN AGRICULTOR
if(isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    
    $stmt = $conn->prepare("DELETE FROM agricultor WHERE id_agricultor = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>
            alert('✅ Agricultor eliminado con éxito.');
            window.location.href = '../views/agricultores/listar.php';
        </script>";
    } else {
        echo "❌ Error al eliminar: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>