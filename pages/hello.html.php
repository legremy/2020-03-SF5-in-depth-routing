<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://bootswatch.com/4/darkly/bootstrap.min.css">

    <title>Hello</title>
</head>

<body>
    <div class="container">
        <h1>Hello <?= $name; ?></h1>
        <p><a href="<?= $this->generator->generate('list'); ?>">Retour à la liste</a></p>
    </div>
</body>

</html>