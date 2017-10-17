<?php
require_once 'assets/partial/header.php';
$_SESSION['mail'] = '';


if(empty($_SESSION['user_id'])){
    header('Location: index.php');
}

$order = $bdd->prepare('SELECT id, total_price, date FROM orders WHERE id_user = :id ORDER BY id DESC');
$order->execute(array(':id' => $_SESSION['user_id']));

$order2 = $bdd->prepare('SELECT id, total_price, date FROM orders WHERE id_user = :id ORDER BY id DESC');
$order2->execute(array(':id' => $_SESSION['user_id']));

generateHeader('order_history');
?>

<h1 id="title_page">Order History</h1>


        <?php
    if ($order2 -> fetch()) {
        ?>
        <div class="contener">
            <div class="cart">
                <?php
                while ($donnees = $order->fetch()) {
                    ?>
                    <h5 class="cart_top"> Order Number : <?php echo $donnees['id']; ?>, Total Price
                        : <?php echo $donnees['total_price']; ?> SEK, Date : <?php echo $donnees['date']; ?></h5>
                    <?php
                    $product = $bdd->prepare('SELECT p.name, ol.* FROM orders_line ol, product p WHERE p.id = ol.id_product AND id_order = :id');
                    $product->execute(array(':id' => $donnees['id']));
                    while ($info = $product->fetch()) {
                        ?>
                        <div>
                            <p> <?php echo $info['quantity']; ?> x <?php echo $info['name']; ?>
                                , <?php echo $info['price']; ?> SEK</p>
                        </div>
                        <?php
                    }
                    $product->closeCursor();
                }
                ?>
            </div>
        </div>
<?php
        }
        else{
            ?>
            <div class='message'>
                <p> You don't have any order yet
                <p>
                <p>To have an order history : <a href="index.php">Start your Shopping now</a></p>
            </div>
            <?php
        }
            $order->closeCursor();
            $order2->closeCursor();
    ?>




<?php
require_once 'assets/partial/footer.php';
?>