<?php
require_once 'assets/partial/header.php';

if (empty ($_GET['id'])){
    header("Location: index.php");
    die();
}

$req = $bdd->prepare('SELECT * FROM shoes_it.user WHERE id = :id_user');
$req->execute(array(':id_user' => $_GET['id']));
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

$mail->Subject = "Account created";
$mail->Body    =  "Hello $firstname $lastname,

<br> <br> Shoes'it team welcomes you!

<br> <br> You can now start your shopping ! Enjoy !

<br> <br> See you soon on Shoes'it - http://localhost/Project/index.php

<br> <br> Shoes'it Team ";

if($mail->send()) {
    $sentMessage = true;
}

generateHeader('new_account_confirmation');
?>

<h1 id="title_page">Registration Done !</h1>

<?php
if ($sentMessage){
    ?>
    <div class="message">
        <p>Thank you !</p>
        <p>Your registration is done, we will send you an e-mail.</p>
        <p>Now to login and start making your shoes'shopping : <a href="login.php">Go Here</a></p>
    </div>
<?php
}
else{
    ?>
    <div class="message">
        <p>Thank you !</p>
        <p>Your registration is done, but email could not be sent. (Mailer Error: <?php echo $mail->ErrorInfo; ?>)</p>
        <p>Now to login and start making your shoes'shopping : <a href="login.php">Go Here</a></p>
    </div>
    <?php
}
?>


<?php
require_once 'assets/partial/footer.php';
?>

