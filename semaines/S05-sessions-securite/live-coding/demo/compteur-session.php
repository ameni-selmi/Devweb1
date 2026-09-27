<?php
// Version session : le navigateur ne garde que PHPSESSID, le compteur est sur le serveur
session_start();
$_SESSION['visits'] = ($_SESSION['visits'] ?? 0) + 1;
echo "Visites (session) : {$_SESSION['visits']}";
