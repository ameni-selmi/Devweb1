<?php
// Version cookie : l'utilisateur peut modifier la valeur dans les DevTools
$visits = (int) ($_COOKIE['visits'] ?? 0) + 1;
setcookie('visits', (string) $visits);
echo "Visites (cookie) : $visits";
