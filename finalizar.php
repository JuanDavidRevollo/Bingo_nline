<?php
session_start();
@unlink('estado_juego.json');
@unlink('sala.json');
session_destroy();
header("Location: index.php");