<?php require APP_ROOT . '/views/inc/head.php'; ?>

<body>
    <?php require APP_ROOT . '/views/inc/nav.php'; ?>
    <div class="banner">
        <h1>SHOPPING ONLINE</h1>
        <p>Đặt hàng bất kì nơi đâu;)</p>
    </div>
    <div class="title">Xem giỏ hàng</div>
    <table id ="table">
        <?php
        $count = 0;
        $total =0;
        if(isset($_SESSION['cart']) && count($_SESSION['cart']) >0) {?>
            <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>

            </tr>
            <?php
            foreach ($_SESSION['cart'] as $key =>$value) {
                $total += $value['price'] * $value ['quantity']; ?>
                <tr>
                    <td><?= ++$count?></td>
                    <td><?= $value['productName']?></td>
                    <td><img src="<?= URL_ROOT . '/public/images/' . $value['productImage'] ?>" alt=""></td>
                    <td><input type="number" value="<?= $value['quantity'] ?>"></td>
                    <td><?= number_format($value['price'],0,'',',') ?> VND</td>
                </tr>
            <?php }
            ?>
        <?php
        }
        ?>
    </table>
   
    <?php require APP_ROOT . '/views/inc/footer.php'; ?>
</body>

</html>