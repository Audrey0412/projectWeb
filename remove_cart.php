<?php

require_once 'assets/partial/header.php';

$_SESSION['mail'] = '';

for ($i = 0; $i < count($_SESSION['cart']); $i++) {
    if ($_SESSION['cart'][$i]['id'] == $_GET['id']) {
        $_SESSION['cart'][$i]['quantity']--;
        if ($_SESSION['cart'][$i]['quantity'] == 0) {
            array_splice($_SESSION['cart'], $i, 1);
            $i--;
        }
    }
}

header("Location: ".$_SERVER['HTTP_REFERER']);

?>