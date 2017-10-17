<?php

require_once 'assets/partial/header.php';

if (empty($_SESSION['user_id'])) {
    header("Location: index.php");
    die();
}

$admin = $bdd->prepare('SELECT * FROM `user` WHERE id = :id AND admin= :admin');
$admin->execute(array(':id' => $_SESSION['user_id'], ':admin' => 1));

if ($secure = $admin->fetch()) {
    $req = $bdd->prepare('UPDATE user SET `admin` = :bool  WHERE `id` = :user_id');
    $req->execute(array(':bool' => 1, ':user_id' => htmlentities($_GET['id'])));
}

header('Location: admin.php');

?>