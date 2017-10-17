<?php

require_once 'assets/partial/header.php';
$_SESSION['mail'] = '';

if (empty($_SESSION['user_id'])) {
    header("Location: index.php");
    die();
}

if (isset($_SESSION['cart']) && count($_SESSION['cart'])!= 0) {

    $cart_info = array();

    $total_price = 0;

    foreach ($_SESSION['cart'] as $info) {
        $prod = $bdd->prepare('SELECT p.price, p.id, p.name FROM product p WHERE p.id = :id');
        $prod->execute(array(':id' => $info['id']));
        $data = $prod->fetch();
        $cart_info[] = ['id' => $data['id'], 'name' => $data['name'], 'price' => $data['price'], 'quantity' => $info['quantity']];
        $total_price = $total_price + $data['price'];
    }

    $req = $bdd->prepare('INSERT INTO shoes_it.orders (id_user, total_price) VALUES (:id_user, :total_price)');
    $req = $req->execute(array(':id_user' => $_SESSION['user_id'], ':total_price' => $total_price));

    $order = $bdd->lastInsertId();

    foreach ($cart_info as $cart_item) {
        $req2 = $bdd->prepare('INSERT INTO shoes_it.orders_line (id_order, id_product, quantity, price) VALUES (:id_order, :id_product, :quantity, :price)');
        $req2 = $req2->execute(array(':id_order' => $order, ':id_product' => $cart_item['id'], ':quantity' => $cart_item['quantity'], ':price' => $cart_item['price']));
    }

    $_SESSION['cart'] = array();

    $hist = $bdd->prepare('SELECT p.name, ol.* FROM orders_line ol, product p WHERE p.id = ol.id_product AND id_order = :id');
    $hist->execute(array(':id' => $order));

    $req = $bdd->prepare('SELECT * FROM shoes_it.user WHERE id = :id_user');
    $req->execute(array(':id_user' => $_SESSION['user_id']));
    $donnees = $req -> fetch();
    $lastname = $donnees['lastname'];
    $firstname = $donnees['firstname'];
    $email = $donnees['email'];

    $sentMessage = false;

    require 'assets/lib/PHPMailer-master/PHPMailerAutoload.php';

    $mail = new PHPMailer;

    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';                       // Specify main and backup server
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'projetwebaudrey@gmail.com';         // SMTP username
    $mail->Password = 'ProjetWeb2017';                        // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
    $mail->Port = 587;                                    //Set the SMTP port number - 587 for authenticated TLS
    $mail->setFrom('projetwebaudrey@gmail.com', 'projetwebaudrey@gmail.com');     //Set who the message is to be sent from
    $mail->addAddress($email);        // Name is optional
    $mail->WordWrap = 50;                                 // Set word wrap to 50 characters
    $mail->isHTML(true);                                  // Set email format to HTML

    $mail->Subject = "Order Validated";
    $mail->Body    =  "Hello $firstname $lastname,

<br> <br> Shoes'it confirm your order !

<br> <br> To see your history order go on - http://audrey.bastien-robert.xyz/my_account.php

<br> <br> Hope to see you soon on Shoes'it - http://localhost/Project/order_history.php

<br> <br> Shoes'it Team ";

    if($mail->send()) {
        $sentMessage = true;
    }

}
else{
    header('Location: index.php');
    die();
}

generateHeader('cart');

?>

<div class="center-class">
    <h1 id="title_page">Order Confirmation</h1>

    <?php
    if ($sentMessage){
        ?>
        <div>
            <p>Thank's you for your order, we will send you an e-mail</p>
            <p> Your order will be ready in few days. This is a summary of your order.</p>
        </div>
        <?php
    }
    else{
        ?>
        <div>
            <p>Thank you !</p>
            <p>Thank's you for your order, but email confirmation could not be sent. (Mailer Error: <?php echo $mail->ErrorInfo; ?>)</p>
            <p> Your order will be ready in few days. This is a summary of your order.</p>
        </div>
        <?php
    }
    ?>
</div>

<div class="contener">
    <div class="cart">
        <div class="cart_top">
            <p>Product</p>
            <p>Quantity</p>
            <p>Price</p>
        </div>

        <table class="cart_center_prod">
        <?php
        while ($donnees = $hist->fetch()) {
            ?>
                <tr>
                    <td class="left"><?php echo $donnees['name']; ?></td>
                    <td class="center"><?php echo $donnees['quantity']; ?></td>
                    <td class="right"><?php echo $donnees['price']; ?> SEK</td>
                </tr>
            <?php
        }
        ?>
        </table>
        <div class="cart_bottom">
            <p>Total <?php echo $total_price ?> SEK</p>
        </div>
    </div>
</div>
<div class="button">
    <a href="my_account.php">
        Go to your profile
    </a>
</div>

<?php
require_once 'assets/partial/footer.php';
?>
