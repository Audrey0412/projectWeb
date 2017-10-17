<?php
require_once 'assets/partial/header.php';
$_SESSION['mail'] = '';

$error_message = '';

if(empty($_SESSION['user_id'])){
    header('Location: index.php');
    die();
}
else{
    $admin = $bdd->prepare('SELECT * FROM `user` WHERE id = :id AND admin= :admin');
    $admin->execute(array(':id' => $_SESSION['user_id'], ':admin' => 1));
    if ($secure=$admin->fetch()) {

        if(isset($_POST['name'])) {
            if (empty($_POST['name']) || empty($_POST['brand']) || empty($_POST['price'])) {
                $errorMsg = "One field is compulsory";
            }
            else {
                if (!is_numeric($_POST['price'])) {
                    $errorMsg = "Enter a price with numbers";
                }
                else {
                    $edit = $bdd->prepare('UPDATE product SET `name` = :name , `price` = :price , `brand` = :brand WHERE id = :id');
                    $edit = $edit->execute(array(':name' => htmlentities($_POST['name']), ':price' => htmlentities($_POST['price']), ':brand' => htmlentities($_POST['brand']), ':id' => $_GET['id']));
                }
            }
        }

        $req = $bdd->prepare('SELECT * FROM product WHERE id = :id');
        $req->execute(array(':id' => $_GET['id']));

        $donnees = $req->fetch();

        generateHeader('edit_product');
        ?>

        <h1 id="title_page">Administrator Interface</h1>

        <div class="contain">
            <div class="login">
                <div class="login_head">Edit Product</div>
                <div class="login_content">
                    <form action="edit_product.php<?php echo '?id=' . $donnees['id'] . ''; ?>" method="post">

                        <?php echo !empty($errorMsg) ? '<p>' . $errorMsg . '</p>' : ''; ?>

                        <div class="login_form">
                            <div class="product_img">
                                <img src="assets/img/product/<?php echo $donnees['image']; ?>" alt="Picture of Shoes" />
                            </div>
                        </div>
                        <div class="login_form">
                            <label for="name">Name :</label>
                            <input type="text" id="name" name="name" value="<?php echo $donnees['name']; ?>"/>
                        </div>
                        <div class="login_form">
                            <label for="brand">Brand :</label>
                            <input type="text" id="brand" name="brand" value="<?php echo $donnees['brand']; ?>"/>
                        </div>
                        <div class="login_form">
                            <label for="price">Price :</label>
                            <input type="text" id="price" name="price" value="<?php echo $donnees['price']; ?>"/>
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

    }
    else{
            header('Location: index.php');
        }
}
?>