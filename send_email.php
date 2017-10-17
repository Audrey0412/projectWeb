<?php

if (empty($_POST['email']) || empty($_POST['object']) || empty($_POST['message'])){
    header("Location: index.php");
    die();
}

$mailFrom=$_POST['email'];
$object=$_POST['object'];
$message=$_POST['message'];

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
$mail->addAddress('audrey.lavillat@efrei.net');        // Name is optional
$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = "$object";
$mail->Body    =  "$message <br/> <br/> $mailFrom";

if($mail->send()) {
    $sentMessage = true;
}

?>

<?php
require_once 'assets/partial/header.php';
generateHeader('contact');
?>

<div>
    <h1 id="title_page">Contact Us</h1>
</div>

<?php

if ($sentMessage){
    ?>
    <div class="message">
        <p>Thank you, Your message has been sent.</p>
    </div>
    <?php
}
else {
    ?>
    <div class="message">
        <p>Message could not be sent.</p>
        <p>Mailer Error: <?php echo $mail->ErrorInfo; ?></p>
    </div>
    <?php
}
?>

<?php
require_once 'assets/partial/footer.php';
?>