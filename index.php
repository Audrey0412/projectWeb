<?php
require_once 'assets/partial/header.php';
$_SESSION['mail'] = '';
generateHeader('index');
?>

<h1 id="title_page">Welcome on Shoes'It !</h1>

<div class="contain_gender">
    <div class="item_gender">
        <a href="products.php?gender=W">
            <img src="assets/img/main_img_women.jpg" alt="Picture of Women Shoes" />
            <div class="title_gender">
                <h2>Women</h2>
                <h3>Shoes</h3>
            </div>
        </a>
    </div>
    <div class="item_gender">
        <a href="products.php?gender=M">
            <img src="assets/img/main_img_men.jpg" alt="Picture of Men Shoes" />
            <div class="title_gender">
                <h2>Men</h2>
                <h3>Shoes</h3>
            </div>
        </a>
    </div>
    <div class="item_gender">
        <a href="products.php?gender=K">
            <img src="assets/img/main_img_kids.jpg" alt="Picture of Kids Shoes" />
            <div class="title_gender">
                <h2>Kids</h2>
                <h3>Shoes</h3>
            </div>
        </a>
    </div>

</div>

<?php
require_once 'assets/partial/footer.php';
?>
