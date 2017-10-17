<?php

require_once 'assets/partial/header.php';

if (empty($_SESSION['user_id'])) {
    header("Location: index.php");
    die();
}

$admin = $bdd->prepare('SELECT * FROM `user` WHERE id = :id AND admin= :admin');
$admin->execute(array(':id' => $_SESSION['user_id'], ':admin' => 1));

if ($secure = $admin->fetch()) {
    $req = $bdd->prepare('DELETE FROM shoes_it.user WHERE `id`= :id');
    $rep = $req->execute(array('id' => $_GET['id']));
}

header("Location: admin.php");

?>
