<?php
require('src/config/config.php');

$auth = new Auth();
$auth->logout();

header('Location: ./index.php');