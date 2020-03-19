<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">

    <title>Détails de la tâche <?= $task['title'] ?></title>
</head>

<body>
    <div class="container">
        <h1>Détails de <em><?= $task['title'] ?></em></h1>
        <p><?= $task['description'] ?></p>
        <p>
            La tâche est <strong><?= $task['completed'] ? "complétée" : "encore à faire" ?> !</strong>
        </p>
        <p><a href="<?= $this->generator->generate('create'); ?>">Créer une autre tâche</a></p>
        <p><a href="<?= $this->generator->generate('list'); ?>">Retour à la liste</a></p>
    </div>
</body>

</html>