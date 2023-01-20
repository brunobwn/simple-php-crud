<?php
session_start();
date_default_timezone_set("America/Sao_Paulo");
require('./src/database/config.php');
require('./src/utils/sessionStorage.php');
require('./src/utils/auth.php');

if (isset($_POST['email']) && isset($_POST['password']) && !isset($_SESSION['user'])) {
    $error['message'] = '';
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    $stmt = $mysqli->prepare("SELECT * FROM users WHERE email= ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_object();
        if (password_verify($password, $user->password)) {
            setSession('user', $user);
            echo 'logou';
        }
    } else {
        $error['message'] = 'Usuário ou senha inválidos';
    }
}

if (isset($_SESSION['user'])) {
    $userLogado = getSession('user');
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
            crossorigin="anonymous">
        <link rel="stylesheet" href="./styles/global.css">
    </head>

    <body class="bg-light min-h-100">
        <?php
    if (!isLoggedIn()) {
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
    </body>

</html>
<?php
$mysqli->close();
?>