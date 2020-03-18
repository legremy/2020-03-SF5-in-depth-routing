<?php
$data = require_once "data.php";
$id = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
if (!$id || !array_key_exists($id, $data)) {
    throw new Exception("La tâche demandée n'existe pas !");
}
$task = $data[$id];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://bootswatch.com/4/darkly/bootstrap.min.css">

    <title>Détails de la tâche <?= $task['title'] ?></title>
</head>

<body>
    <div class="container">
        <h1>Détails de <em><?= $task['title'] ?></em></h1>
        <p><?= $task['description'] ?></p>
        <p>
            La tâche est <strong><?= $task['completed'] ? "complétée" : "encore à faire" ?> !</strong>
        </p>
        <a href="index.php">Retour à la liste</a> ou <a href="index.php?page=create">Créer une autre tâche</a>
    </div>
</body>

</html>