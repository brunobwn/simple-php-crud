<?php
require('src/config/config.php');

$error['message'] = '';
$auth = new Auth();

// verifica se possui cookie de lembrar login
if (isset($_COOKIE['login_data']) && !$auth->isAuthenticated()) {
    $decrypted = decryptLogin();
    if (!is_null($decrypted) && isset($decrypted['email']) && isset($decrypted['password'])) {
        $auth->login($decrypted['email'], $decrypted['password']);
    }
}

if (isset($_POST['email']) && isset($_POST['password']) && !$auth->isAuthenticated()) {
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;
    $login = $auth->login($email, $password);

    if (isset($_POST['remember_me']) && $_POST['remember_me'] === '1') {
        $token = encryptLogin($email, $password);
        // Definir o cookie 7 dias expiração
        setcookie('login_data', $token, time() + (60 * 60 * 24 * 7), '/', null, null, true);
    }

    if (!$login) {
        $error['message'] = 'Usuário ou senha inválidos';
    }

    unset($_POST);
}

?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Page</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65"
            crossorigin="anonymous" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-avatar@latest/dist/avatar.min.css"
            rel="stylesheet" />
        <link rel="stylesheet" href="src/styles/global.css" />
    </head>

    <body class="bg-light min-h-100">
        <?php
    if (!$auth->isAuthenticated()) {
        include('./src/pages/login.php');
    } else {
        include('./src/pages/home.php');
    }
    ?>

        <!-- Bootstrap JavaScript Libraries -->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
            integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
            crossorigin="anonymous">
        </script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
            integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz"
            crossorigin="anonymous">
        </script>
        <script type="text/javascript" src="./src/js/app.js"></script>
    </body>

</html>