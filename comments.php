<?php
require_once 'assets/partial/header.php';
$_SESSION['mail'] = '';

if(isset($_POST['comment']) && !empty($_POST['comment'])) {

    $comment = htmlentities($_POST['comment']);
    $req = $bdd->prepare('INSERT INTO shoes_it.comment (id_user, message) values (:user_id, :message)');
    $req = $req->execute(array(':user_id' => $_SESSION['user_id'] , ':message' => htmlentities($_POST['comment'])));

    if($req){
        header("Location: comments.php");
    }
}

$rep = $bdd->query('SELECT c.*, u.username FROM comment c , user u WHERE c.id_user = u.id ORDER BY c.id DESC');


generateHeader('comments');
?>

    <h1 id="title_page">Comments Page</h1>

<?php
if(!empty($_SESSION['user_id'])){
    ?>
    <div class="center-class">
        <form action="comments.php" method="post">
            <div class="row">
                <label for="comment">Leave a message : </label>
                <textarea id="comment" name="comment"></textarea>
            </div>
            <div class="row">
                <button type="submit">Add a comment</button>
            </div>
        </form>
    </div>
    <?php
}

else{
    ?>
    <div class ="info">
        <p> To add a comment <a class="link" href="login.php"> Connect </a> or <a class="link" href="new_account.php"> Create your account</a> </p>
    </div>
    <?php
}
?>

<div class="contain">
    <table>
        <?php
        $cpt = 0;
        while ($donnees = $rep->fetch())
        {
            ?>
            <tr>
                <td class="name"> <p> <?php echo $donnees['username']; ?> </p> </td>
                <td class="message"> <p > <?php echo $donnees['message']; ?> </p> </td>
                <td class="trash"> <p> <?php if ((!empty($_SESSION['user_id'])) && ($_SESSION['user_id'] == $donnees['id_user'])){ ?> <a class="link" href="delete_comments.php<?php echo '?id='.$donnees['id'].''; ?>"> <span class="fa fa-trash-o"></span> <?php } ?> </a></p> </td>
            </tr>
            <?php
        }
        ?>
    </table>
</div>
<?php
require_once 'assets/partial/footer.php';
?>