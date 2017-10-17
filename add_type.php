<?php
require_once 'assets/partial/header.php';
$_SESSION['mail'] = '';

if (empty($_SESSION['user_id'])) {
    header("Location: index.php");
    die();
}

$admin = $bdd->prepare('SELECT * FROM `user` WHERE id = :id AND admin= :admin');
$admin->execute(array(':id' => $_SESSION['user_id'], ':admin' => 1));

if ($secure = $admin->fetch()) {

    if (isset($_POST['name'])) {
        if (empty($_POST['name'])) {
            $error_message = 'You must enter a name';
        } else {
            if ($_POST['gender'] == 'error') {
                $error_message = 'You must select a type';
            } else {
                $req = $bdd->prepare('INSERT INTO shoes_it.type (name, gender) VALUES (:name, :gender)');
                $req = $req->execute(array(':name' => htmlentities($_POST['name']), ':gender' => htmlentities($_POST['gender'])));
                $error_message = 'The new type has been added';
            }
        }
    }

    generateHeader('add_type');
    ?>

    <h1 id="title_page">Administrator Interface</h1>

    <nav class="nav_admin_menu">
        <div class="contain_top">
            <ul>
                <a href="admin.php">
                    <li>User Roles</li>
                </a>
                <a class="active" href="add_type.php">
                    <li>Add a Type</li>
                </a>
                <a href="add_product.php">
                    <li>Add a Product</li>
                </a>
            </ul>
        </div>

        <div class="contain_down">
            <div class="box">
                <form action="add_type.php" method="post">

                    <?php echo !empty($error_message) ? '<p class="center">' . $error_message . '</p>' : ''; ?>

                    <div class="type_form">
                        <label for="name">Name :</label>
                        <input type="text" id="name" name="name"/>
                    </div>
                    <div class="type_form">
                        <select id="gender" name="gender">
                            <option value="error">
                                Select a gender
                            </option>
                            <option value="W">
                                Women
                            </option>
                            <option value="M">
                                Men
                            </option>
                            <option value="K">
                                Kids
                            </option>
                        </select>
                    </div>
                    <div class="type_form">
                        <button type="submit">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </nav>


    <?php
    require_once 'assets/partial/footer.php';

}
else{
    header('Location: index.php');
}
?>