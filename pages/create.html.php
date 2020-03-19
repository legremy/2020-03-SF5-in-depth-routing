<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">

    <title>Créer une tâche</title>
</head>

<body>
    <div class="container">
        <?php if (!empty($data)) : ?>
            <div class="jumbotron">
                <p class="lead">Bravo, le formulaire a été soumis.</p>
                <p>Il resterait à traiter les données ci-dessous</p>
                <code>
                    <pre><?php var_dump($data); ?></pre>
                </code>
            </div>
        <?php endif; ?>
        <h1>Créer une nouvelle tâche</h1>

        <form action="" method="POST">
            <div class="form-group">
                <input class="form-control" type="text" name="title" placeholder="Titre de la tâche">
            </div>
            <div class="form-group">
                <input class="form-control" type="text" name="description" placeholder="Description de la tâche">
            </div>
            <div class="form-group">
                <select class="form-control" name="priority">
                    <option value="1">Priorité faible</option>
                    <option value="2">Priorité moyenne</option>
                    <option value="3">Priorité forte</option>
                </select>
            </div>
            <div class="form-group">
                <label>Tâche terminée ?
                    <input type="checkbox" name="completed">
                </label>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Enregistrer</button>
            </div>
        </form>

        <a href="<?= $this->generator->generate('list'); ?>">Retour à la liste</a>
    </div>
</body>

</html>