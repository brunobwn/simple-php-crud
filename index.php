<?php
require('src/config/config.php');

$error['message'] = '';
$auth = new Auth();

// verifica rota
$page = filter_input(INPUT_GET, 'pg', FILTER_SANITIZE_URL) ?? 'home';
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_URL);

// verifica se possui cookie de lembrar login
if (isset($_COOKIE['login_data']) && !$auth->isAuthenticated()) {
    $decrypted = decryptLogin();
    if (!is_null($decrypted) && isset($decrypted['email']) && isset($decrypted['password'])) {
        $auth->login($decrypted['email'], $decrypted['password']);
    }
}


// realiza login
if ($action == 'login' && ($_SERVER['REQUEST_METHOD'] === 'POST')) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_ADD_SLASHES);
    $login = $auth->login($email, $password);

    if ($login && isset($_POST['remember_me']) && $_POST['remember_me'] === '1') {
        $token = encryptLogin($email, $password);
        // Definir o cookie 7 dias expiração
        setcookie('login_data', $token, time() + (60 * 60 * 24 * 7), '/', null, null, true);
    }

    if (!$login) {
        $error['message'] = 'Usuário ou senha inválidos';
    }

    unset($_POST);
}

// realiza cadastro
if ($action == "register" && ($_SERVER['REQUEST_METHOD'] === 'POST')) {
    if ($_POST['password'] === $_POST['passwordConfirm']) {
        $registration = $auth->create($_POST['email'], $_POST['password'], $_POST['name'], $_POST['picture']);
        if ($registration[0] === false) {
            $error['message'] = $registration[1];
        } else {
            $auth->login($_POST['email'], $_POST['password']);
            $page = 'home';
        }
    } else {
        $error['message'] = 'As senhas digitadas não conferem';
    }
    unset($_POST);
}
?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>myToDoList</title>
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
    if (!$auth->isAuthenticated() && $page !== 'register') {
        include('./src/pages/login.php');
    } else {
        if (!file_exists('src/pages/' . $page . '.php')) {
            include('./src/pages/404.php');
        }
        if ($auth->isAuthenticated() && ($page === 'login')) {
            $page = 'home';
        }
        include('./src/pages/' . $page . '.php');
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