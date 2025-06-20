<?php
require_once '../config/database.php';

// METODO PARA REGISTRAR UN COLABORADOR
if(isset($_POST['registrar_colaborador'])) {
    $nombre = trim($_POST['nombre']);
    $documento = trim($_POST['documento']);
    $cargo = trim($_POST['cargo']);
    $contacto = trim($_POST['contacto']);
    $id_agricultor = trim($_POST['id_agricultor']);

    // Validación
    if (empty($nombre) || empty($documento) || empty($id_agricultor)) {
        echo "<script>
            alert('❌ Nombre, documento y agricultor son obligatorios.');
            window.history.back();
        </script>";
        exit;
    }

    // Insertar datos
    $stmt = $conn->prepare("INSERT INTO colaborador (nombre, documento, cargo, contacto, id_agricultor) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdi", $nombre, $documento, $cargo, $contacto, $id_agricultor);

    if ($stmt->execute()) {
        echo "<script>
            alert('✅ Colaborador registrado con éxito.');
            window.location.href = '../views/colaboradores/listar.php';
        </script>";
    } else {
        echo "<script>
            alert('❌ Error al registrar: " . addslashes($stmt->error) . "');
            window.history.back();
        </script>";
    }

    $stmt->close();
}

// METODO PARA EDITAR UN COLABORADOR
if(isset($_POST['editar_colaborador'])) {
    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $documento = trim($_POST['documento']);
    $cargo = trim($_POST['cargo']);
    $contacto = trim($_POST['contacto']);
    $id_agricultor = trim($_POST['id_agricultor']);

    // Validación
    if (empty($nombre) || empty($documento) || empty($id_agricultor)) {
        echo "<script>
            alert('❌ Nombre, documento y agricultor son obligatorios.');
            window.history.back();
        </script>";
        exit;
    }

    $stmt = $conn->prepare("UPDATE colaborador SET nombre = ?, documento = ?, cargo = ?, contacto = ?, id_agricultor = ? WHERE id_colaborador = ?");
    $stmt->bind_param("sssdii", $nombre, $documento, $cargo, $contacto, $id_agricultor, $id);

    if ($stmt->execute()) {
        echo "<script>
            alert('✅ Colaborador actualizado con éxito.');
            window.location.href = '../views/colaboradores/listar.php';
        </script>";
    } else {
        echo "<script>
            alert('❌ Error al actualizar: " . addslashes($stmt->error) . "');
            window.history.back();
        </script>";
    }

    $stmt->close();
}

// METODO PARA ELIMINAR UN COLABORADOR
if(isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    
    $stmt = $conn->prepare("DELETE FROM colaborador WHERE id_colaborador = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>
            alert('✅ Colaborador eliminado con éxito.');
            window.location.href = '../views/colaboradores/listar.php';
        </script>";
    } else {
        echo "<script>
            alert('❌ Error al eliminar: " . addslashes($stmt->error) . "');
            window.location.href = '../views/colaboradores/listar.php';
        </script>";
    }

    $stmt->close();
}

$conn->close();
?>