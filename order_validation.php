<?php
require_once 'assets/partial/header.php';

if(!empty($_SESSION['user_id'])){
    header('Location: order_done.php');
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

        if(!empty($_SESSION['cart'])){
            header('Location: cart.php');
        }
        else{
            header("location: index.php");
        }
    }
    else{
        $error_message = 'User or Password is incorrect !';
    }
}

if(isset($_POST['email'])) {
    if (empty($_POST['email'])) {
        $error_message2 = 'Enter your email';
    } else {
        $regex = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';
        if (!preg_match($regex, $_POST['email'])) {
            $error_message2 = 'You need to enter a valid e-mail adress';
        } else {
            $req = $bdd->prepare('SELECT COUNT(*) FROM shoes_it.user WHERE email LIKE :email');
            $req->execute(array(':email' => htmlentities($_POST['email'])));

            if ($req->fetchColumn() != 0) {
                $error_message2 = 'An user already exist with this e-mail adress';
            } else {
                $_SESSION['mail'] = $_POST['email'];
                header("location: new_account.php");
            }
        }
    }
}


generateHeader('order_validation');
?>

<h1 id="title_page">Order Confirmation</h1>
<div class = content>
<div class="login">
    <div class="login_head">Login</div>
    <div class="login_content">
        <form action="order_validation.php" method="post">
            <?php echo !empty($error_message)?'<p>'.$error_message.'</p>':''; ?>
            <div class="login_form">
                <label for="username">Username :</label>
                <input type="text" id="username" name="username" />
            </div>
            <div class="login_form">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" />
            </div>
            <div class="login_form">
                <button type="submit">Login</button>
            </div>
        </form>
    </div>
</div>

    <div class="login">
        <div class="login_headR">Registration</div>
        <div class="login_content">
            <form action="order_validation.php" method="post">

                <?php echo !empty($error_message2)?'<p>'.$error_message2.'</p>':''; ?>

                <div class="login_form">
                    <label for="email">E-mail :</label>
                    <input type="email" id="email" name="email" />
                </div>
                <div class="login_form">
                    <button type="submit">Register</button>
                </div>
            </form>
        </div>
    </div>
    

</div>

<?php
require_once 'assets/partial/footer.php';
?>
