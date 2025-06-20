<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir Documento</title>
</head>
<body>
    <h2>Subir Documento</h2>
    <form action="../../controller/documentoController.php" method="POST" enctype="multipart/form-data">
        <label for="tipo_documento">Tipo de Documento:</label><br>
        <select id="tipo_documento" name="tipo_documento" required>
            <option value="">Seleccione...</option>
            <option value="contrato">Contrato</option>
            <option value="nomina">Nómina</option>
            <option value="certificado">Certificado</option>
            <option value="otro">Otro</option>
        </select><br><br>
        
        <label for="archivo">Archivo:</label><br>
        <input type="file" id="archivo" name="archivo" required><br><br>
        
        <button type="submit" name="subir_documento">Subir Documento</button>
    </form>
    <a href="listar.php">Volver a documentos</a>
</body>
</html>