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
    $req = $bdd->query('SELECT * FROM shoes_it.user');

    generateHeader('admin');
    ?>

    <h1 id="title_page">Administrator Interface</h1>
    <nav class="nav_admin_menu">
        <div>
            <ul>
                <a class="active" href="admin.php">
                    <li>User Roles</li>
                </a>
                <a href="add_type.php">
                    <li>Add a Type</li>
                </a>
                <a href="add_product.php">
                    <li>Add a Product</li>
                </a>
            </ul>
        </div>
        <div>
            <table>
                <tr class="head">
                    <td><p>First Name</p></td>
                    <td><p>Last Name</p></td>
                    <td><p>Admin</p></td>
                    <td><p>Delete</p></td>
                </tr>
                <?php
                while ($donnees = $req->fetch()) {
                    ?>
                    <tr>
                        <td><p class="lastname"> <?php echo $donnees['lastname']; ?> </p></td>
                        <td><p class="firstname"> <?php echo $donnees['firstname']; ?> </p></td>
                        <td><p> <?php if ($donnees['admin'] == 1) { ?> <a class="admin" href="transform_user.php<?php echo '?id=' . $donnees['id'] . ''; ?>">Admin</a> <?php } else { ?><a class="user" href="transform_admin.php<?php echo '?id=' . $donnees['id'] . ''; ?>" >User</a> <?php } ?> </p></td>
                        <td><p><a class="trash" href="delete_user.php<?php echo '?id='.$donnees['id'].''; ?>"><span class="fa fa-trash-o"></span></a></p></td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
    </nav>


    <?php
    require_once 'assets/partial/footer.php';

}
else{
    header('Location: index.php');
}
?>