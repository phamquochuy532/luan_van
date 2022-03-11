<?php require APP_ROOT . '/views/inc/head.php'; ?>

<body>
    <?php require APP_ROOT . '/views/inc/nav.php'; ?>
    <div class="banner">
        <h1>SHOPPING ONLINE</h1>
        <p>Đặt hàng bất kì nơi đâu;)</p>
    </div>
    <div class="title">Sản phẩm <?= $data['product']['name'] ?></div>
    <main class="container">
        <div class="left-column">
            <img src="<?= URL_ROOT ?>/public/images/<?= $data['product']['image'] ?>" alt="">
        </div>
        <div class="right-column">
            <div class="product-description">
                <h1><?= $data['product']['name'] ?></h1>
                <p><?= $data['product']['description'] ?></p>
            </div>
            <div class="product-price">
                <span> ₫<?= number_format($data['product']['promotionPrice'], 0, '', ',') ?></span>
                <a href="#" class="cart-btn">Thêm vào giỏ</a>
            </div>
        </div>
    </main>
    <?php require APP_ROOT . '/views/inc/footer.php'; ?>
</body>

</html>