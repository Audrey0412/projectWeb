<?php

require_once 'assets/partial/header.php';
$_SESSION['mail'] = '';

$quantity = 1;

$_TEMP = array('id' => $_GET['id'], 'quantity' => $quantity);

if (isset($_SESSION['cart'])){
    $var = 0;
    for ($i = 0; $i < count($_SESSION['cart']); $i++) {
        
        if($_SESSION['cart'][$i]['id'] == $_GET['id']){
            $_SESSION['cart'][$i]['quantity']++;
            $var = 1;
        }
    }
    if($var == 0){
        $_SESSION['cart'][] = $_TEMP;
    }
}
else{
    $_SESSION['cart'] = array($_TEMP);
}

header("Location: ".$_SERVER['HTTP_REFERER']);

?>

