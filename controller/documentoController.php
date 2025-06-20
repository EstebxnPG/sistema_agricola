<?php
require_once '../config/database.php';

// SUBIR DOCUMENTO
if(isset($_POST['subir_documento'])) {
    $tipo_documento = trim($_POST['tipo_documento']);
    
    // Manejo de archivo
    $nombre_archivo = $_FILES['archivo']['name'];
    $ruta_temporal = $_FILES['archivo']['tmp_name'];
    $ruta_destino = "../uploads/documentos/" . basename($nombre_archivo);
    
    if(move_uploaded_file($ruta_temporal, $ruta_destino)) {
        $stmt = $conn->prepare("INSERT INTO documento (tipo_documento, nombre_archivo, ruta_archivo, fecha_subida) VALUES (?, ?, ?, NOW())");
        $stmt->bind_param("sss", $tipo_documento, $nombre_archivo, $ruta_destino);

        if ($stmt->execute()) {
            echo "<script>
                alert('✅ Documento subido con éxito.');
                window.location.href = '../views/documentos/listar.php';
            </script>";
        } else {
            echo "❌ Error al subir documento: " . $stmt->error;
        }
    } else {
        echo "❌ Error al mover el archivo.";
    }
}

// ELIMINAR DOCUMENTO
if(isset($_GET['eliminar_documento'])) {
    $id_documento = $_GET['eliminar_documento'];
    
    // Obtener la ruta para eliminar el archivo físico
    $stmt = $conn->prepare("SELECT ruta_archivo FROM documento WHERE id_documento = ?");
    $stmt->bind_param("i", $id_documento);
    $stmt->execute();
    $result = $stmt->get_result();
    $documento = $result->fetch_assoc();
    
    if($documento) {
        // Eliminar archivo físico
        if(file_exists($documento['ruta_archivo'])) {
            unlink($documento['ruta_archivo']);
        }
        
        // Eliminar registro de la base de datos
        $stmt = $conn->prepare("DELETE FROM documento WHERE id_documento = ?");
        $stmt->bind_param("i", $id_documento);
        
        if ($stmt->execute()) {
            echo "<script>
                alert('✅ Documento eliminado con éxito.');
                window.location.href = '../views/documentos/listar.php';
            </script>";
        } else {
            echo "❌ Error al eliminar documento: " . $stmt->error;
        }
    }
}

$conn->close();
?>