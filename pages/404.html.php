<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/public/css/bootstrap.min.css">
    <title>Page non trouvée :'(</title>
</head>

<body>
    <div class="container">
        <h1>Ooops ! La page demandée n'existe pas !</h1>
        <p><a href="<?= $generator->generate('list'); ?>">Retour à la liste</a></p>
    </div>
</body>

</html>