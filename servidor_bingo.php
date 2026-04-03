<?php
header('Content-Type: application/json');
$archivo = 'estado_juego.json';
// Nomenclatura hasta E99
if (!file_exists($archivo) || (time() - filemtime($archivo) > 12)) {
    $letras = ['A', 'B', 'C', 'D', 'E'];
    $ficha = $letras[array_rand($letras)] . str_pad(rand(0, 99), 2, "0", STR_PAD_LEFT);
    $datos = ['actual' => $ficha, 'historial' => []];
    if (file_exists($archivo)) {
        $previo = json_decode(file_get_contents($archivo), true);
        $datos['historial'] = is_array($previo['historial']) ? $previo['historial'] : [];
    }
    array_unshift($datos['historial'], $ficha);
    file_put_contents($archivo, json_encode($datos));
}
echo file_get_contents($archivo);