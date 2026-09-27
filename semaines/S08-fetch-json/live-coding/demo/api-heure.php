<?php
// Démo S08 : un endpoint qui renvoie du JSON au lieu du HTML
header('Content-Type: application/json; charset=utf-8');

$names = ['Amine', 'Sarra', 'Nour', 'Yassine'];

echo json_encode([
    'time' => date('H:i:s'),
    'visitor' => $names[array_rand($names)],
    'luckyNumber' => random_int(1, 100),
], JSON_UNESCAPED_UNICODE);
