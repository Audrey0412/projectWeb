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

    $req = $bdd->query('SELECT * FROM type');
    $req2 = $bdd->query('SELECT * FROM type');
    $req3 = $bdd->query('SELECT * FROM type');

    //To add a new product
    if(isset($_POST['name'])) {
        if (empty($_POST['name']) || empty($_POST['brand']) || empty($_POST['price'])) {
            $errorMsg = "One field is compulsory";
        } else {
            if (!is_numeric($_POST['price'])) {
                $errorMsg = "Enter a price with numbers";
            } else {
                if ($_POST['type'] == 'error') {
                    $errorMsg = 'You must select a type';
                } else {
                    //Check if it's an image
                    if (getimagesize($_FILES["image"]["tmp_name"]) == false) {
                        $errorMsg = 'You must add an image';
                    } else {
                        //Check the size if the image
                        if ($_FILES["image"]["size"] > 500000) {
                            $errorMsg = 'Your image is too large !';
                        } else {
                            // Check the extension of the image
                            $extension = pathinfo($_FILES["image"]["name"])['extension'];
                            if ($extension != "jpg" && $extension != "png" && $extension != "jpeg")
                                $errorMsg = 'Sorry, only JPG, JPEG, PNG files are allowed !';
                            else {
                                //Check if one image doesn't already exist with this extension
                                $path = 'assets/img/product/';
                                $name = '';
                                do {
                                    $name = time() . rand(0, 100) . '.' . $extension;
                                } while (file_exists($path . $name));

                                //We try to move the image, if it doesn't work we show an error
                                if (move_uploaded_file($_FILES["image"]["tmp_name"], $path . $name)) {

                                    $add = $bdd->prepare('INSERT INTO `product` (name, price, brand, image) VALUES (:name, :price, :brand, :image)');
                                    $add = $add->execute(array(':name' => htmlentities($_POST['name']), ':price' => htmlentities($_POST['price']), ':brand' => htmlentities($_POST['brand']), ':image' => $name));

                                    $product = $bdd->lastInsertId();


                                    $add2 = $bdd->prepare('INSERT INTO `type_product` (id_product, id_type) VALUES (:id_product, :id_type)');
                                    $add2 = $add2->execute(array(':id_product' => $product, ':id_type' => ($_POST['type'])));

                                    if ($_POST['type2']!= -1) {
                                        $add3 = $bdd->prepare('INSERT INTO `type_product` (id_product, id_type) VALUES (:id_product, :id_type)');
                                        $add3 = $add3->execute(array(':id_product' => $product, ':id_type' => ($_POST['type2'])));
                                    }

                                    if ($_POST['type3']!= -1) {
                                        $add4 = $bdd->prepare('INSERT INTO `type_product` (id_product, id_type) VALUES (:id_product, :id_type)');
                                        $add4 = $add4->execute(array(':id_product' => $product, ':id_type' => ($_POST['type3'])));
                                    }
                                    
                                    if ($add && $add2) {
                                        $errorMsg = 'Your product has been added';
                                    } else {
                                        $errorMsg = 'An unknow error occured';
                                    }
                                } else {
                                    $errorMsg = 'An unknow error occured while uploading the file';
                                }
                            }

                        }

                    }
                }
            }
        }
    }

generateHeader('add_product');
?>

    <h1 id="title_page">Administrator Interface</h1>

    <nav class="nav_admin_menu">
        <div class="contain_top">
            <ul>
                <a href="admin.php">
                    <li>User Roles</li>
                </a>
                <a href="add_type.php">
                    <li>Add a Type</li>
                </a>
                <a class="active" href="add_product.php">
                    <li>Add a Product</li>
                </a>
            </ul>
        </div>

        <div class="contain_down">
            <div class="box">
                <form action="add_product.php" method="post" enctype="multipart/form-data">

                    <?php echo !empty($errorMsg) ? '<p class="center">' . $errorMsg . '</p>' : ''; ?>

                    <div class="type_form_img">
                        <label for="image">Image :</label>
                        <input type="file" name="image" id="image" />
                    </div>
                    <div class="type_form">
                        <label for="name">Name :</label>
                        <input type="text" id="name" name="name"/>
                    </div>
                    <div class="type_form">
                        <label for="brand">Brand :</label>
                        <input type="text" id="brand" name="brand"/>
                    </div>
                    <div class="type_form">
                        <label for="price">Price :</label>
                        <input type="text" id="price" name="price"/>
                    </div>
                    <div class="type_form">
                        <select id="type" name="type">
                            <option value="error">
                                Select a type
                            </option>
                            <?php while ($type = $req->fetch()) {
                                ?>
                                <option value="<?php echo $type['id']; ?>">
                                    <?php echo $type['name']; ?> (<?php echo $type['gender']; ?>)
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="type_form">
                        <select id="type2" name="type2">
                            <option value="-1">
                                Select a type (option)
                            </option>
                            <?php while ($type2 = $req2->fetch()) {
                                ?>
                                <option value="<?php echo $type2['id']; ?>">
                                    <?php echo $type2['name']; ?> (<?php echo $type2['gender']; ?>)
                                </option>
                                <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="type_form">
                        <select id="type3" name="type3">
                            <option value="-1">
                                Select a type (option)
                            </option>
                            <?php while ($type3 = $req3->fetch()) {
                                ?>
                                <option value="<?php echo $type3['id']; ?>">
                                    <?php echo $type3['name']; ?> (<?php echo $type3['gender']; ?>)
                                </option>
                                <?php
                            }
                            ?>
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
