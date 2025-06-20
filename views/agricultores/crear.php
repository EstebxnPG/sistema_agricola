<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Agricultor</title>
</head>
    <?php 
        // Conexión base de datos.
        require_once '../../config/database.php';
    ?>
<body>
    <h2>Formulario de Registro de Agricultor</h2>
    <form action="../../controller/agricultorController.php" method="POST"> <!-- Enviamos el formulario x metodo  POST a el controller -->

    <!-- Solicitando campos -->
        <label for="nombre">Nombre:</label><br>
        <input type="text" id="nombre" name="nombre" required><br><br>

        <label for="documento">Documento:</label><br>
        <input type="text" id="documento" name="documento" required><br><br>

        <label for="contacto">Contacto:</label><br>
        <input type="text" id="contacto" name="contacto"><br><br>

        <label for="email">Correo Electrónico:</label><br>
        <input type="email" id="email" name="email"><br><br>

        <button type="submit" name="registrar_agricultor">Registrar Agricultor</button>
    </form>
    <a href="listar.php">Volver</a>
</body>
</html>
