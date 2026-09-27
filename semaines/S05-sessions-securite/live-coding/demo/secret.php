<?php
session_start();
// Sans ces deux lignes, n'importe qui peut ouvrir cette page en tapant son adresse
if (!isset($_SESSION['name'])) {
    header('Location: mini-login.php');
    exit;
}
echo 'Page secrète, réservée à ' . htmlspecialchars($_SESSION['name']);
