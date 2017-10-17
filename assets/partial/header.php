<?php

session_start();

$bdd = new PDO('mysql:host=localhost;dbname=shoes_it;charset=utf8', 'root', 'root');
//$bdd = new PDO('mysql:host=localhost;dbname=shoes_it;charset=utf8', 'c0audrey', 'Efrei2017');

if (!empty($_SESSION['user_id'])){
    $req = $bdd->prepare("SELECT * FROM shoes_it.user WHERE id=:id");
    $req->execute(array(":id" => $_SESSION['user_id']));
    if($req->rowCount() == 0) {
        header("Location: logout.php");
        die();
    }
}   

if (empty($_SESSION['ip']) || $_SESSION['ip'] != $_SERVER['REMOTE_ADDR']) {
    $_SESSION['ip'] = '';
    $_SESSION['user_id'] = '';
    setcookie('user_id', '', 0, '/');
}

if (empty($_SESSION['user_id']) && !empty($_COOKIE['user_id'])){
    $_SESSION['user_id'] = $_COOKIE['user_id'];
}

function generateHeader($cssFile, $activePage = '')
{
    ?>

    <!DOCTYPE html>

    <html>
    <head>
        <meta charset="utf-8"/>
        <link rel="stylesheet" href="assets/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/master.css"/>
        <link rel="stylesheet" href="assets/css/<?php echo $cssFile; ?>.css"/>
        <title>Home</title>
    </head>

<body>
    <nav id="nav_main_menu">
        <div class="burger">
            <i class="fa fa-bars" onClick="document.getElementsByTagName('body')[0].classList.toggle('open-menu');"> </i>
        </div>
        <div class="logo">
            <a href="index.php">
                <img class='image' src="assets/img/logo.png" alt="Picture of Shoes"/>
            </a>
        </div>
        <div class="links">
            <a href="index.php" class="no-large">
                <img class='image' src="assets/img/logo.png" alt="Picture of Shoes"/>
            </a>
            <ul>
                <a class="<?php echo $activePage == 'W' ? 'active' : ''; ?>" href="products.php?gender=W"><li>Women</li></a>
                <a class="<?php echo $activePage == 'M' ? 'active' : ''; ?>" href="products.php?gender=M"><li>Men</li> </a>
                <a class="<?php echo $activePage == 'K' ? 'active' : ''; ?>" href="products.php?gender=K"><li>Kids</li> </a>
                <a class="<?php echo $cssFile == 'search' ? 'active' : ''; ?>" href="search.php"><li>Search</li> </a>
                <a class="<?php echo $cssFile == 'comments' ? 'active' : ''; ?>" href="comments.php"><li>Comments</li> </a>
                <a class="<?php echo $cssFile == 'contact' ? 'active' : ''; ?>" href="contact.php"><li>Contact</li> </a>
                <a class="<?php echo $cssFile == 'cart' ? 'active' : ''; ?>" href="cart.php"><li>Cart</li> </a>
                <a class="<?php echo $cssFile == 'about_us' ? 'active' : ''; ?>" href="about_us.php"><li>About Us</li> </a>
            </ul >
        </div>
        <?php
        if (!empty($_SESSION['user_id'])) {
            ?>
            <div class="account">
                <a href="my_account.php">
                    <i class="fa fa-user-o" ></i> My Account
                </a>
            </div>
            <?php
        }
        else{
            ?>
            <div class="account">
                <a href="login.php">
                    <i class="fa fa-user-o" ></i> Login
                </a>
            </div>
            <?php
        }
        ?>
    </nav>
        <div class="master-container">
            <div class="master-content">

        <?php
    }
    ?>