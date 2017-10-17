<?php

require_once 'assets/partial/header.php';

$_SESSION['mail'] = '';

if (!empty($_SESSION['user_id'])) {
    header("Location: index.php");
    die();
}

$error_message = '';

if(isset($_POST['username'])){
    if(!empty($_POST['username']) && !empty($_POST['password'])) {

        $req = $bdd->prepare('SELECT `id`, `password` FROM `shoes_it`.`user` WHERE username LIKE :username');
        $req->execute(array(':username' => htmlentities($_POST['username'])));
        $result = $req->fetch();
    }
    
    if(!empty($result['password']) && hash_equals($result['password'], crypt($_POST['password'], $result['password']))) {

        $_SESSION['user_id'] = $result['id'];
        $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

        if (isset($_POST['remember'])){
            setcookie('user_id', $result['id'], time() + 365 * 24 * 3600, '/');
            setcookie('username_id', $_POST['username'], time() + 365 * 24 * 3600, '/');
        }

        if(!empty($_SESSION['cart'])){
            header('Location: cart.php');
            die();
        }
        else{
            header("location: index.php");
            die();
        }
    }
    else{
        $error_message = 'User or Password is incorrect !';
    }
}


generateHeader('login');
?>
<div class="contain">
    <div class="login">
        <div class="login_head">Login</div>
        <div class="login_content">
            <p>If you don't have an account : <a class="link" href="new_account.php"> Go here to create one !</a></p>
            <form action="login.php" method="post">
                <?php echo !empty($error_message)?'<p>'.$error_message.'</p>':''; ?>
                <div class="login_form">
                    <label for="username">Username :</label>
                    <input type="text" id="username" name="username" value="<?php echo !empty($_COOKIE['username_id']) ? $_COOKIE['username_id'] : '' ; ?>"/>
                </div>
                <div class="login_form">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" />
                </div>
                <div class="remember">
                    <input type="checkbox" id="remember" name="remember">Remember me</input>
                </div>
                <div class="login_form">
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once 'assets/partial/footer.php';
?>
