<?php require APP_ROOT . '/views/inc/head.php'; ?>

<body>
    <?php require APP_ROOT . '/views/inc/nav.php'; ?>
    <div class="banner">
        <h1>SHOPPING ONLINE</h1>
        <p>Đặt hàng bất kì nơi đâu;)</p>
    </div>
    <div class="title">Xem giỏ hàng</div>
    <table id="table">
        <?php
        $count = 0;
        $total = 0;
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) { ?>
            <tr>
                <th>STT</th>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Số lượng</th>
                <th>Đơn giá</th>
                <th>Thao tác</th>
            </tr>
            <?php
            foreach ($_SESSION['cart'] as $key => $value) {
                $total += $value['price'] * $value['quantity']; ?>
                <tr>
                    <td><?= ++$count ?></td>
                    <td><?= $value['productName'] ?></td>
                    <td><img class="img-table" src="<?= URL_ROOT . '/public/images/' . $value['productImage'] ?>" alt=""></td>
                    <td><input min="1" onchange="update(this)" id="<?= $value['productId'] ?> " class="qty" type="number" value="<?= $value['quantity'] ?>"></td>
                    <td><?= number_format($value['price'], 0, '', ',') ?> VND</td>
                    <td><a class="rm-item-cart" href="<?= URL_ROOT ?>/cart/removeItemCart/<?= $value['productId'] ?>"><i class="fa fa-trash"></i></a></td>
                </tr>
            <?php } ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>Tổng</td>
                <td><?= number_format($total, 0, '', ',') ?> VND</td>
            </tr>
        <?php } else { ?>
            <h3>Giỏ hàng hiện đang rỗng...</h3>
        <?php }
        ?>
    </table>

    <?php require APP_ROOT . '/views/inc/footer.php'; ?>
    <Script>
        var list = document.getElementsByClassName("qty");
        for (let item of list) {
            item.addEventListener("keypress", function(evt) {
                evt.preventDefault();
            });
        }

        function update(e) {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "http://localhost/luan_van/cart/updateItemCart/" + e.id + "/" + e.value, true);
            xhr.send();
            xhr.onload = function() {
                if (xhr.readyState === 4) {
                    var status = xhr.status;
                    if (status === 200) {
                        setTimeout(
                            function() {
                                window.location.reload();
                            }, 1000
                        );
                    } else if (status === 501) {
                        alert('Số lượng sản phẩm không đủ để thêm vào giỏ hàng!');
                        window.location.reload();
                    } else {
                        alert('Cập nhật số lượng thất bại!');
                        window.location.reload();
                    }
                }
            }
        }
    </Script>
</body>

</html>