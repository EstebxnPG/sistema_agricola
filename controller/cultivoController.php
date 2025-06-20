<?php
require_once '../config/database.php';

// Configuración para subida de imágenes
$uploadDir = '../uploads/cultivos/';
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Crear nuevo cultivo
if(isset($_POST['registrar_cultivo'])) {
    $nombre = trim($_POST['nombre']);
    $fecha_siembra = trim($_POST['fecha_siembra']);
    $ubicacion = trim($_POST['ubicacion']);
    $id_agricultor = trim($_POST['id_agricultor']);
    
    // Procesar imagen
    $imagenNombre = '';
    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $imagenNombre = uniqid().'.'.$ext;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir.$imagenNombre);
    }

    // Validación
    if(empty($nombre) || empty($id_agricultor)) {
        echo "<script>
            alert('El nombre y el agricultor son obligatorios');
            window.history.back();
        </script>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO cultivo (nombre, fecha_siembra, ubicacion, imagen, id_agricultor) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssi", $nombre, $fecha_siembra, $ubicacion, $imagenNombre, $id_agricultor);

    if($stmt->execute()) {
        echo "<script>
            alert('Cultivo registrado con éxito');
            window.location.href = '../views/cultivos/listar.php';
        </script>";
    } else {
        // Eliminar imagen si hubo error
        if($imagenNombre && file_exists($uploadDir.$imagenNombre)) {
            unlink($uploadDir.$imagenNombre);
        }
        echo "<script>
            alert('Error al registrar: ".addslashes($stmt->error)."');
            window.history.back();
        </script>";
    }
    $stmt->close();
}

// Actualizar cultivo
if(isset($_POST['editar_cultivo'])) {
    $id = $_POST['id'];
    $nombre = trim($_POST['nombre']);
    $fecha_siembra = trim($_POST['fecha_siembra']);
    $ubicacion = trim($_POST['ubicacion']);
    $id_agricultor = trim($_POST['id_agricultor']);
    
    // Obtener cultivo actual para la imagen
    $stmt = $conn->prepare("SELECT imagen FROM cultivo WHERE id_cultivo = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $cultivoActual = $result->fetch_assoc();
    $stmt->close();
    
    // Procesar nueva imagen
    $imagenNombre = $cultivoActual['imagen'];
    if(isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        // Eliminar imagen anterior si existe
        if($imagenNombre && file_exists($uploadDir.$imagenNombre)) {
            unlink($uploadDir.$imagenNombre);
        }
        
        $ext = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $imagenNombre = uniqid().'.'.$ext;
        move_uploaded_file($_FILES['imagen']['tmp_name'], $uploadDir.$imagenNombre);
    }

    $stmt = $conn->prepare("UPDATE cultivo SET nombre=?, fecha_siembra=?, ubicacion=?, imagen=?, id_agricultor=? WHERE id_cultivo=?");
    $stmt->bind_param("ssssii", $nombre, $fecha_siembra, $ubicacion, $imagenNombre, $id_agricultor, $id);

    if($stmt->execute()) {
        echo "<script>
            alert('Cultivo actualizado con éxito');
            window.location.href = '../views/cultivos/listar.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al actualizar: ".addslashes($stmt->error)."');
            window.history.back();
        </script>";
    }
    $stmt->close();
}

// Eliminar cultivo
if(isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    
    // Obtener imagen para eliminarla
    $stmt = $conn->prepare("SELECT imagen FROM cultivo WHERE id_cultivo = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $cultivo = $result->fetch_assoc();
    $stmt->close();
    
    // Eliminar cultivo
    $stmt = $conn->prepare("DELETE FROM cultivo WHERE id_cultivo=?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()) {
        // Eliminar imagen asociada
        if($cultivo['imagen'] && file_exists($uploadDir.$cultivo['imagen'])) {
            unlink($uploadDir.$cultivo['imagen']);
        }
        echo "<script>
            alert('Cultivo eliminado con éxito');
            window.location.href = '../views/cultivos/listar.php';
        </script>";
    } else {
        echo "<script>
            alert('Error al eliminar: ".addslashes($stmt->error)."');
            window.location.href = '../views/cultivos/listar.php';
        </script>";
    }
    $stmt->close();
}

$conn->close();
?>