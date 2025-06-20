<?php


require_once '../config/database.php';

// METODO PARA REGISTRAR UN AGRICULTOR
if(isset($_POST['registrar_agricultor'])) {
     $nombre = trim($_POST['nombre']);
    $documento = trim($_POST['documento']);
    $contacto = trim($_POST['contacto']);
    $email = trim($_POST['email']);

    // Validación simple (puedes mejorarla)
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

$conn->close();
?>
}