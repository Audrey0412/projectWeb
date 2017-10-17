<?php
require_once 'assets/partial/header.php';
$_SESSION['mail'] = '';

if(empty($_SESSION['user_id'])){
    header('Location: index.php');
    die();
}

$req = $bdd->prepare('SELECT firstname, lastname, admin FROM shoes_it.user WHERE id = :user_id');
$req->execute(array(':user_id' => $_SESSION['user_id']));

$donnees = $req->fetch();

generateHeader('my_account');
?>

<h1 id="title_page">Hello, <span class="firstname"><?php echo $donnees['firstname']; ?></span> <span class="lastname"><?php echo $donnees['lastname']; ?></span></h1>

<div class="contain">
    <div class="block">
        <a href="order_history.php">
            <div> <i class="fa fa-archive"></i> </div>
            <div> <p>My Orders</p></div>
        </a>
    </div>
    <div class="block">
        <a href="edit_profile.php">
            <div> <i class="fa fa-address-card-o"></i> </div>
            <div> <p>My Informations</p></div>
        </a>
    </div>
    <div class="block">
        <a href="logout.php">
            <div> <i class="fa fa-sign-out"></i> </div>
            <div> <p>Log Out</p></div>
        </a>
    </div>
    
    <?php
    if ($donnees['admin']==1){
    ?>
    <div class="block">
        <a href="admin.php">
            <div><i class="fa fa-lock"></i></div>
            <div><p>Administrator</p></div>
        </a>
        <?php
        }
        ?>
    </div>

</div>

<?php
require_once 'assets/partial/footer.php';
?>