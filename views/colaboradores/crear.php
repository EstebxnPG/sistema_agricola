<?php require_once '../../config/database.php'; ?>

<!-- VIEW - Para el registro de un nuevo agricultor. -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Agricultor</title>
</head>
<body>
    <h2>Registrar nuevo Agricultor</h2>

    <form action="../../controller/agricultorController.php" method="POST">

        <label for="">Nombre: </label>
        <input type="text" name="nombre" required> <br><br>

        <label for="">Documento: </label>
        <input type="text" name="documento" required> <br><br>

        <label for="">Cargo: </label>
        <input type="text" name="cargo" required> <br><br>

        <label for="">Contacto: </label>
        <input type="number" name="contacto" required> <br><br>

        <label for="">Precio venta: </label>
        <input type="number" name="precio_venta" id=""><br><br>

        <button type="submit" name="registrar_agricultor">CREAR</button>
    </form>

    <p><a href="listar.php">Ver Productos</a></p>
</body>
</html>