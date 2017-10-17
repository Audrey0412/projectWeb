<?php

require_once 'assets/partial/header.php';
$_SESSION['mail'] = '';

$cart_info = array();

$total_price = 0;

if (isset($_SESSION['cart']) && count($_SESSION['cart'])!=0){
    foreach ($_SESSION['cart'] as $info)
    {
    $prod = $bdd->prepare('SELECT p.price, p.id, p.name FROM product p WHERE p.id = :id');
    $prod->execute(array(':id' => $info['id']));
    $data = $prod->fetch();
    $cart_info[] = ['id' => $data['id'], 'name' => $data['name'], 'price' => $data['price'], 'quantity' => $info['quantity']];
    $total_price = $total_price + ($info['quantity'] * $data['price']);
    }
}

generateHeader('cart');

?>

<div class="main_page">
<div class="center-class">
    <h1 id="title_page">Your Cart</h1>
    <?php
        if (isset($_SESSION['cart']) && count($_SESSION['cart'])!=0){
            ?>
            <p>Your cart is ready to be validate.</p>
            <p>Please verify the items that are inside your cart.</p>
            <p>When you're ready click on validate to confirm your purchase.</p>
            <?php
        }
        ?>

<div class="contener">
    <div class="cart">
        <div class="cart_top">
            <p>Product</p>
            <p>Quantity</p>
            <p>Price</p>
        </div>
        <?php
        if (!isset($_SESSION['cart']) || count($_SESSION['cart'])==0){
            ?>
            <div class="cart_center">
                <p>Your cart is empty</p>
            </div>
            <?php
        }
        else{
            ?>
            <table class="cart_center_prod">
            <?php
            foreach ($cart_info as $cart_item){
                ?>
                    <tr>
                        <td class = "left"><?php echo $cart_item['name']; ?></td>
                        <td class = "center"><?php echo $cart_item['quantity']; ?></td>
                        <td class="prod_plus">
                            <a href="add_cart.php<?php echo '?id='.$cart_item['id'].''; ?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        </td>
                        <td class="prod_minus">
                            <a href="remove_cart.php<?php echo '?id='.$cart_item['id'].''; ?>"><i class="fa fa-minus" aria-hidden="true"></i></a>
                        </td>
                        <td class="prod_cancel">
                            <a href="delete_cart.php<?php echo '?id='.$cart_item['id'].''; ?>"><i class="fa fa-times" aria-hidden="true"></i></a>
                        </td>
                        <td class = "right"><?php echo $cart_item['price'] ; ?> SEK</td>
                    </tr>
        <?php
            }
            ?>
            </table>
        <?php
        }
        ?>
        <div class="cart_bottom">
            <p>Total <?php echo $total_price ?> SEK</p>
        </div>
    </div>
</div>
<div class="button">
    <a href="products.php?gender=W">
        <i class="fa fa-arrow-left"></i> Go back to Shopping
    </a>
    <?php
    if (isset($_SESSION['cart']) && count($_SESSION['cart'])!=0){
        ?>
        <a href="order_validation.php">
            Validate your Order <i class="fa fa-arrow-right"></i>
        </a>
        <?php
    }
    ?>
</div>
</div>
<?php
require_once 'assets/partial/footer.php';
?>
