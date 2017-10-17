<?php

require_once 'assets/partial/header.php';

if (empty($_SESSION['user_id'])) {
    header("Location: comments.php");
    die();
}

$req = $bdd->prepare('DELETE FROM comment WHERE `id`= :id AND `id_user` = :user_id');
$rep = $req->execute(array('id' => $_GET['id'], 'user_id' => $_SESSION['user_id']));

header("Location: comments.php");

?>
