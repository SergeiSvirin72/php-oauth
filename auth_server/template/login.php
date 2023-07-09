<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <style>
        .error {
            color: red;
            margin-bottom: 10px;
        }
        input {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<div class="error">
    <?= $error ?>
</div>
<form action="<?= $url ?>" method="post">
    <label for="email">E-mail:</label><br>
    <input type="text" id="email" name="email"><br>

    <label for="password">Password:</label><br>
    <input type="password" id="password" name="password"><br>

    <input type="submit" name="submit" value="Login">
</form>
</body>
</html>
