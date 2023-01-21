<?php
require(dirname(__FILE__) . '/loader.php');

$auth = new Auth();
$auth->logout();

header('Location: ./index.php');