<?php
session_start();
session_destroy(); // Limpia sesiones anteriores para evitar errores de datos viejos
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bingo - Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="contenedor">
        <h1>Bienvenido</h1>
        <h3>Ingresa tu nombre para jugar</h3>
        <form method="POST" action="espera.php">
            <input type="text" name="nombre" placeholder="Nombre" required>
            <input type="submit" value="INICIAR">
        </form>
    </div>
</body>
</html>