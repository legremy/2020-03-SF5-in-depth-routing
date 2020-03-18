<?php
$data = require_once 'data.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste des tâches</title>
    <link rel="stylesheet" href="https://bootswatch.com/4/darkly/bootstrap.min.css">
</head>

<body>
    <div class="container">

        <h1>Liste des tâches</h1>

        <a href="<?= $generator->generate('create'); ?>">Créer une tâche</a>

        <?php foreach ($data as $id => $task) : ?>
            <h2><?= $task['title'] ?> (<?= $task['completed'] ? "Complète" : "Incomplète" ?>)</h2>
            <small>Priorité : <?= $task['priority'] ?></small><br>
            <a href="<?= $generator->generate('show', ["id" => $id]); ?>">En savoir plus</a>
            <hr>
        <?php endforeach ?>
    </div>
</body>

</html>