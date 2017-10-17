<?php
session_start();
$_SESSION['ip'] = '';
$_SESSION['user_id'] = '';
$_SESSION['mail'] = '';
$_SESSION['cart'] = array();
setcookie('user_id', '', 0, '/');
header ('Location: index.php');

?>
