<?php
header('Content-Type: application/json');
echo file_exists('sala.json') ? file_get_contents('sala.json') : json_encode([]);