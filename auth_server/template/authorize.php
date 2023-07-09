<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Authorize</title>
    <style>

    </style>
</head>
<body>
<div><?= $client ?> wants to authorize your account: <?= $email ?></div>
<div>Permissions:</div>
<ul>
    <?php foreach ($scopes as $scope): ?>
        <li><?= $scope->getIdentifier() ?></li>
    <?php endforeach; ?>
</ul>
<form action="<?= $url ?>" method="post">
    <button name="submit" value="0" type="submit">Cancel</button>
    <button name="submit" value="1" type="submit">Authorize</button>
</form>
</body>
</html>
