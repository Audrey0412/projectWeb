<?php

require_once 'assets/partial/header.php';

if(!empty($_SESSION['user_id'])){
    header('Location: index.php');
    die();
}

$error_message = '';

if(isset($_POST['username'])){
    if (empty($_POST['username']) || empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email']) || empty($_POST['password'])) {
        $error_message = 'One field is compulsory';
    } else {
        if (strlen($_POST['password']) < 5) {
            $error_message = 'Password need to be at least 5 characters';
        } else {
            $regex = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';

            if (!preg_match($regex, $_POST['email'])) {
                $error_message = 'You need to enter a valid e-mail adress';
            } else {
                $req = $bdd->prepare('SELECT COUNT(*) FROM shoes_it.user WHERE email LIKE :email OR username LIKE :username');
                $req->execute(array(':username' => htmlentities($_POST['username']), ':email' => htmlentities($_POST['email'])));

                if ($req->fetchColumn() != 0) {
                    $error_message = 'An user already exist with this e-mail adress or this username';
                } else {
                    $salt = sprintf("$2a$%02d$", 10) . strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
                    $hash = crypt($_POST['password'], $salt);

                    $req = $bdd->prepare('INSERT INTO shoes_it.user (username, firstname, lastname, email, password) VALUES (:username, :firstname, :lastname, :email, :password)');
                    $req = $req->execute(array(':username' => htmlentities($_POST['username']), ':firstname' => htmlentities($_POST['firstname']), ':lastname' => htmlentities($_POST['lastname']), ':email' => htmlentities($_POST['email']), ':password' => $hash));

                    $user = $bdd->lastInsertId();
                    
                    // Test to verify if the request is executed
                    if ($req) {
                        $_SESSION['mail'] = '';
                        header("location: new_account_confirmation.php?id=".$user);
                        die();
                    }
                    else {
                        $error_message = 'An unknow error occured';
                    }
                }
            }
        }
    }
}

generateHeader('new_account');

?>

<h1 id="title_page">New Account Creation</h1>
    
<div class="contain">
    <div class="login">
        <div class="login_head">Registration</div>
        <div class="login_content">
            <form action="new_account.php" method="post">
                <?php echo !empty($error_message)?'<p>'.$error_message.'</p>':''; ?>
                <div class="login_form">
                    <label for="lastname">Last Name :</label>
                    <span>*</span>
                    <input type="text" id="lastname" name="lastname" />
                </div>
                <div class="login_form">
                    <label for="firstname">First Name :</label>
                    <span>*</span>
                    <input type="text" id="firstname" name="firstname" />
                </div>
                <div class="login_form">
                    <label for="email">E-mail :</label>
                    <span>*</span>
                    <input type="email" id="email" name="email" value="<?php echo $_SESSION['mail']; ?>"/>
                </div>
                <div class="login_form">
                    <label for="username">Username :</label>
                    <span class="mandatory">*</span>
                    <input type="text" id="username" name="username" />
                </div>
                <div class="login_form">
                    <label for="password">Password:</label>
                    <span>*</span>
                    <input type="password" id="password" name="password" />
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