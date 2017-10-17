<?php
require_once 'assets/partial/header.php';
$_SESSION['mail'] = '';
generateHeader('contact');
?>

<h1 id="title_page">Contact Us</h1>

<div class="contener">
    <div class="center-class">
        <form action="send_email.php" method="post">
            <div class="row">
                <label for="email">E-mail :</label>
                <input type="email" required id="email" name="email"/>
            </div>
    
            <div class="row">
                <label for="object">Object :</label>
                <input type="text" required id="object" name="object" />
            </div>
    
            <div class="row">
                <label for="message">Message :</label>
                <textarea id="message" required name="message"></textarea>
            </div>
    
            <div class="row">
                <button type="submit">Send your message</button>
            </div>
        </form>
    </div>
</div>

<?php
require_once 'assets/partial/footer.php';
?>
