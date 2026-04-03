<?php
session_start();
if (!isset($_SESSION['nombre'])) { header("Location: index.php"); exit(); }

function generarCarton() {
    $letras = ['A', 'B', 'C', 'D', 'E']; // Rango hasta E
    $carton = [];
    for ($i = 0; $i < 5; $i++) {
        for ($j = 0; $j < 5; $j++) {
            if ($i == 2 && $j == 2) { $carton[$i][$j] = "FREE"; }
            else {
                $letra = $letras[array_rand($letras)];
                $num = str_pad(rand(0, 99), 2, "0", STR_PAD_LEFT);
                $carton[$i][$j] = $letra . $num;
            }
        }
    }
    return $carton;
}
if (!isset($_SESSION['carton'])) { $_SESSION['carton'] = generarCarton(); }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bingo en Vivo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="contenedor-juego">
        <h2>Jugador: <?php echo htmlspecialchars($_SESSION['nombre']); ?></h2>
        <div id="ficha-actual">--</div>
        <table class="bingo-table">
            <?php foreach ($_SESSION['carton'] as $fila): ?>
                <tr>
                    <?php foreach ($fila as $c): ?>
                        <td class="casilla <?php echo ($c=='FREE')?'marcada-free':''; ?>" onclick="marcar(this)"><?php echo $c; ?></td>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </table>
        <button id="btnBingo" disabled onclick="alert('¡BINGO! Solicitud enviada.')">CANTAR BINGO</button>
        <form action="finalizar.php" method="POST"><button type="submit" class="btn-salir">DETENER</button></form>
    </div>
    <script>
        function marcar(celda) {
            if(celda.innerText !== "FREE") celda.classList.toggle('marcada');
            validar();
        }
        function actualizar() {
            fetch('servidor_bingo.php').then(res => res.json()).then(data => {
                document.getElementById('ficha-actual').innerText = data.actual;
            }).catch(() => window.location.href = 'index.php');
        }
        function validar() {
            const filas = document.querySelectorAll('.bingo-table tr');
            let gano = false;
            for(let i=0; i<5; i++) {
                let h=0, v=0;
                for(let j=0; j<5; j++) {
                    if(filas[i].cells[j].classList.contains('marcada') || filas[i].cells[j].classList.contains('marcada-free')) h++;
                    if(filas[j].cells[i].classList.contains('marcada') || filas[j].cells[i].classList.contains('marcada-free')) v++;
                }
                if(h===5 || v===5) gano = true;
            }
            document.getElementById('btnBingo').disabled = !gano;
        }
        setInterval(actualizar, 3000);
        actualizar();
    </script>
</body>
</html>