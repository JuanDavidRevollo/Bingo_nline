<?php
session_start();
if (isset($_POST['nombre'])) {
    $_SESSION['nombre'] = $_POST['nombre'];
    $archivo = 'sala.json';
    $usuarios = file_exists($archivo) ? json_decode(file_get_contents($archivo), true) : [];
    if (!is_array($usuarios)) $usuarios = [];
    if (!in_array($_SESSION['nombre'], $usuarios)) {
        $usuarios[] = $_SESSION['nombre'];
        file_put_contents($archivo, json_encode($usuarios));
    }
}
if (!isset($_SESSION['nombre'])) { header("Location: index.php"); exit(); }

$url_compartir = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/index.php";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sala de Espera</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="contenedor">
        <h1>Sala de espera</h1>
        <h3>Bienvenido: <?php echo htmlspecialchars($_SESSION['nombre']); ?></h3>
        <div id="lista-jugadores">Cargando...</div>
        <hr>
        <p>Comparte este link para invitar amigos:</p>
        <input type="text" value="<?php echo $url_compartir; ?>" readonly onclick="this.select(); document.execCommand('copy'); alert('¡Link copiado!');">
        <br><br>
        <form action="juego.php" method="POST">
            <input type="submit" value="INICIAR PARTIDA">
        </form>
    </div>
    <script>
        function actualizar() {
            fetch('sala_status.php').then(r => r.json()).then(data => {
                let html = `<h3>Jugadores conectados (${data.length}/20)</h3><ul>`;
                data.forEach(u => { html += `<li>${u}</li>`; });
                document.getElementById('lista-jugadores').innerHTML = html + "</ul>";
            });
        }
        setInterval(actualizar, 2000);
        actualizar();
    </script>
</body>
</html>