<?php
require_once 'assets/partial/header.php';
$_SESSION['mail'] = '';


if (empty($_SESSION['user_id'])) {
    header("Location: index.php");
    die();
}

if(isset($_POST['username'])) {
    if (empty($_POST['username']) || empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['email'])) {
        $error_message1 = 'One field is compulsory';
    } else {
        $regex = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD';

        if (!preg_match($regex, $_POST['email'])) {
            $error_message1 = 'You need to enter a valid e-mail adress';
        } else {
            $req = $bdd->prepare('SELECT COUNT(*) FROM shoes_it.user WHERE (email LIKE :email OR username LIKE :username) AND id != :user_id');
            $req->execute(array(':username' => htmlentities($_POST['username']), ':email' => htmlentities($_POST['email']), ':user_id' => $_SESSION['user_id']));

            if ($req->fetchColumn() != 0) {
                $error_message1 = 'An user already exist with this e-mail adress or this username';
            } else {
                $req = $bdd->prepare('UPDATE shoes_it.user SET `username` = :username , `firstname` = :firstname , `lastname` = :lastname ,  `email` = :email WHERE `id` = :user_id');
                $req = $req->execute(array(':username' => htmlentities($_POST['username']), ':firstname' => htmlentities($_POST['firstname']), ':lastname' => htmlentities($_POST['lastname']), ':email' => htmlentities($_POST['email']), ':user_id' => $_SESSION['user_id']));

                // Test to verify if the request is executed
                if ($req) {

                } else {
                    $error_message1 = 'An unknow error occured';
                }
            }
        }
    }
}

if(isset($_POST['password'])) {
    if (!empty($_POST['new_password'])) {
        $req = $bdd->prepare('SELECT password FROM `shoes_it`.`user` WHERE id = :user_id');
        $req->execute(array(':user_id' => $_SESSION['user_id']));
        $result = $req->fetch();

        if (!empty($result['password']) && hash_equals($result['password'], crypt($_POST['password'], $result['password']))) {
            if (strlen($_POST['new_password']) < 5) {
                $error_message = 'Password need to be at least 5 characters';
            } else {
                $salt = sprintf("$2a$%02d$", 10) . strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
                $hash = crypt($_POST['new_password'], $salt);
                $req = $bdd->prepare('UPDATE shoes_it.user SET password = :new_password WHERE `id` = :user_id');
                $req = $req->execute(array(':new_password' => $hash, ':user_id' => $_SESSION['user_id']));

                if ($req) {
                    $error_message = 'Password changed';
                } else {
                    $error_message = 'An unknow error occured';
                }
            }
        }
        else {
            $error_message = 'Password is incorrect !';
        }
    }
}

$req = $bdd->prepare('SELECT username, firstname, lastname, email FROM shoes_it.user WHERE id = :user_id');
$req->execute(array(':user_id' => $_SESSION['user_id']));

$donnees = $req->fetch();

generateHeader('edit_profile');
?>

<h1 id="title_page">Account Information Page</h1>

<div class="text_center">
    <p>Feel free to change your contact information below to keep your Shoes'it account up-to-date or change your password for more security.</p>
</div>

<div class="contain">
    <div class="login">
    <div class="login_head">Edit Profile</div>
        <div class="login_content">
            <form action="edit_profile.php" method="post">

                <?php echo !empty($error_message1)?'<p>'.$error_message1.'</p>':''; ?>
                <?php echo !empty($error_message)?'<p>'.$error_message.'</p>':''; ?>

                <div class="login_form">
                    <label for="lastname">Last Name :</label>
                    <input type="text" id="lastname" name="lastname" value="<?php echo $donnees['lastname'];?>"/>
                </div>
                <div class="login_form">
                    <label for="firstname">First Name :</label>
                    <input type="text" id="firstname" name="firstname" value="<?php echo $donnees['firstname']; ?>"/>
                </div>
                <div class="login_form">
                    <label for="email">E-mail :</label>
                    <input type="email" id="email" name="email" value="<?php echo $donnees['email'];?>"/>
                </div>
                <div class="login_form">
                    <label for="username">Username :</label>
                    <input type="text" id="username" name="username" value="<?php echo $donnees['username'];?>"/>
                </div>
                <div class="login_form">
                    <label for="password">Old Password:</label>
                    <input type="password" id="password" name="password" />
                </div>
                <div class="login_form">
                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" />
                </div>
                <div class="login_form">
                    <button type="submit">Edit <i class="fa fa-arrow-right"></i></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
require_once 'assets/partial/footer.php';
?>