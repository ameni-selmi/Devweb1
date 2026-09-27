<?php
function e(string|int|float|null $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$name = '';
$error = '';
$ok = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    if (mb_strlen($name) < 3) {
        $error = 'Au moins 3 caractères.';
    } else {
        $ok = true;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head><meta charset="UTF-8"><title>Salut</title></head>
<body>
  <?php if ($ok): ?>
    <p>Salut <?= e($name) ?> !</p>
  <?php endif; ?>
  <form method="post">
    <label for="name">Votre nom</label>
    <input id="name" name="name" required minlength="3" value="<?= e($name) ?>">
    <button>Envoyer</button>
    <small><?= e($error) ?></small>
  </form>
</body>
</html>
