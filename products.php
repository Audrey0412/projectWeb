<?php
require_once 'assets/partial/header.php';
$_SESSION['mail'] = '';
generateHeader('products',$_GET['gender']);

if (isset($_POST['search']) && !empty($_POST['search'])){
    if(empty($_GET['type']))
    {
        $product = $bdd->prepare('SELECT p.* FROM type t, product p, type_product tp WHERE p.id = tp.id_product AND t.id = tp.id_type AND gender= :gender AND (p.name LIKE :search_word OR p.brand LIKE :search_word)');
        $product->execute(array(':gender' => $_GET['gender'], ':search_word' => '%'.$_POST['search'].'%'));
    }
    else
    {
        $product = $bdd->prepare('SELECT p.* FROM type t, product p, type_product tp WHERE p.id = tp.id_product AND t.id = tp.id_type AND tp.id_type = :type AND (p.name LIKE :search_word OR p.brand LIKE :search_word)');
        $product->execute(array(':type' => $_GET['type'], ':search_word' => '%'.$_POST['search'].'%'));
    }
}
else{
    if(empty($_GET['type']))
    {
        $product = $bdd->prepare('SELECT p.* FROM type t, product p, type_product tp WHERE p.id = tp.id_product AND t.id = tp.id_type AND gender= :gender');
        $product->execute(array(':gender' => $_GET['gender']));
    }
    else
    {
        $product = $bdd->prepare('SELECT p.* FROM type t, product p, type_product tp WHERE p.id = tp.id_product AND t.id = tp.id_type AND tp.id_type = :type');
        $product->execute(array(':type' => $_GET['type']));
    }
}

$type = $bdd->prepare('SELECT * FROM type WHERE gender= :gender ORDER BY name ASC');
$type->execute(array(':gender' => $_GET['gender']));

$administrator = 0;

if (!empty($_SESSION['user_id'])) {
    $admin = $bdd->prepare('SELECT * FROM `user` WHERE id = :id AND admin= :admin');
    $admin->execute(array(':id' => $_SESSION['user_id'], ':admin' => 1));
    if($secure=$admin->fetch()){
        $administrator = 1;
    }
}

$cart_info = array();

$total_price = 0;

if (isset($_SESSION['cart'])) {

    foreach ($_SESSION['cart'] as $info) {
        $prod = $bdd->prepare('SELECT p.price, p.id, p.name FROM product p WHERE p.id = :id');
        $prod->execute(array(':id' => $info['id']));
        $data = $prod->fetch();
        $cart_info[] = ['id' => $data['id'], 'name' => $data['name'], 'price' => $data['price'], 'quantity' => $info['quantity']];
        $total_price = $total_price + ($info['quantity'] * $data['price']);
    }
}

?>

<section>
    <aside class="aside_left">
        <div class="type_shoes">
            <h1>Types</h1>
            <ul>
                <li> <a href="products.php?gender=<?php echo $_GET['gender']; ?>">All types</a> </li>
                <?php while ($donnees = $type->fetch())
                {
                    ?>
                    <li> <a href="products.php?type=<?php echo $donnees['id']; ?>&gender=<?php echo $donnees['gender']; ?>"><?php echo $donnees['name']; ?></a> </li>
                    <?php
                }

                $type->closeCursor();
                ?>
            </ul >
        </div>
            <div class="search">
                <div class="search_content">
                        <form action="products.php?gender=<?php echo $_GET['gender']; ?>&type=<?php echo !empty($_GET['type']) ? $_GET['type'] : ''; ?>" method="post">
                            <div class="search_form">
                                <label for="search"></label>
                                <input type="text" id="search" name="search"/>
                            </div>
                            <div class="search_form">
                                <button type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                </div>
            </div>

    </aside>
    <div class="main_page_product">

        <h1 id="title_page"><?php switch ($_GET['gender'])
        {
            case 'W':
                echo "Women's Shoes";
                break;

            case 'M':
                echo "Men's Shoes";
                break;

            case 'K':
                echo "Kids' Shoes";
                break;

            default:
                echo "Error Shoes";
        }
        ?> </h1>
        
        <div class="content_product">
            <?php while ($donnees = $product->fetch())
            {
                ?>
                <div class="product">
                    <div class="product_img">
                        <img src="assets/img/product/<?php echo $donnees['image']; ?>" alt="Picture of Shoes" />
                    </div>
                    <p> <?php echo $donnees['name']; ?></p>
                    <p> <?php echo $donnees['price']; ?> SEK</p>
                    <div class="button_admin">
                    <a href="add_cart.php<?php echo '?id='.$donnees['id'].''; ?>" >Add</a>
                    <?php if ($administrator == 1) {
                            ?>
                            <a href="edit_product.php<?php echo '?id=' . $donnees['id'] . ''; ?>">Edit</a>
                            <?php
                    }
                        ?>
                    </div>
                </div>
                <?php
            }

            $product->closeCursor();
            ?>
        </div>
    </div>
    <aside class="aside_right">
        <div class="cart">
            <div class="cart_top">
                <p><i class="fa fa-shopping-cart"></i> Cart</p>
            </div>

            <div class="cart_center">
                <table>
                    <tbody>
                    <?php
                    if (!isset($_SESSION['cart']) || count($_SESSION['cart'])==0){
                        ?>
                        <div>
                            <p class="pcenter">Your cart is empty</p>
                        </div>
                        <?php
                    }
                    else {
                        foreach ($cart_info as $cart_item) {
                            ?>
                            <tr>
                                <td class="nb_product"><?php echo $cart_item['quantity'] . ' x ' . $cart_item['name'] . ', ' . $cart_item['price'] . ' SEK'; ?></td>
                                <td class="prod_plus">
                                    <a href="add_cart.php<?php echo '?id='.$cart_item['id'].''; ?>">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td class="prod_minus">
                                    <a href="remove_cart.php<?php echo '?id='.$cart_item['id'].''; ?>">
                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                    </a>
                                </td>
                                <td class="prod_cancel">
                                    <a href="delete_cart.php<?php echo '?id='.$cart_item['id'].''; ?>">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
            if (isset($_SESSION['cart']) && count($_SESSION['cart'])>0){
            ?>
                <a href="cart.php" class="link">Validate your order</a>
            <?php
            }
            ?>

            <div class="cart_bottom">
                <p>Total <?php echo $total_price ?> SEK</p>
            </div>
        </div>
    </aside>
</section>

<?php
require_once 'assets/partial/footer.php';
?>