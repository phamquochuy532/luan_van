<?php require APP_ROOT . '/views/inc/head.php'; ?>

<body>
    <?php require APP_ROOT . '/views/inc/nav.php'; ?>
    <div class="banner">
        <h1>SHOPPING ONLINE</h1>
        <p>Đặt hàng bất kì nơi đâu;)</p>
    </div>
    <div class="title">Sản phẩm nổi bật</div>
    <div class="search-container">
        <input type="text" class="search" placeholder="Tìm kiếm.." name="keyword">
        <a href="<?= URL_ROOT ?>/product/search/"> <button type="submit"><i class="fa fa-search"></i></button></a>
    </div>
    <div class="content">
        <div class="card">
            <a href="single.html"><img src="<?= URL_ROOT ?>/public/images/R.jpg" class="product-image" alt=""></a>
            <a href="single.html">
                <h1>Đồ chơi búp bê</h1>
            </a>
            <p class="price">400,000 VND</p>
            <p><button>Thêm vào giỏ</button></p>
        </div>
        <div class="card">
            <a href="single.html"><img src="<?= URL_ROOT ?>/public/images/R.jpg" class="product-image" alt=""></a>
            <a href="single.html">
                <h1>Đồ chơi búp bê</h1>
            </a>
            <p class="price">400,000 VND</p>
            <p><button>Thêm vào giỏ</button></p>
        </div>
        <div class="card">
            <a href="single.html"><img src="<?= URL_ROOT ?>/public/images/R.jpg" class="product-image" alt=""></a>
            <a href="single.html">
                <h1>Đồ chơi búp bê</h1>
            </a>
            <p class="price">400,000 VND</p>
            <p><button>Thêm vào giỏ</button></p>
        </div>
        <div class="card">
            <a href="single.html"><img src="<?= URL_ROOT ?>/public/images/R.jpg" class="product-image" alt=""></a>
            <a href="single.html">
                <h1>Đồ chơi búp bê</h1>
            </a>
            <p class="price">400,000 VND</p>
            <p><button>Thêm vào giỏ</button></p>
        </div>
        <div class="card">
            <a href="single.html"><img src="<?= URL_ROOT ?>/public/images/R.jpg" class="product-image" alt=""></a>
            <a href="single.html">
                <h1>Đồ chơi búp bê</h1>
            </a>
            <p class="price">400,000 VND</p>
            <p><button>Thêm vào giỏ</button></p>
        </div>
        <div class="card">
            <a href="single.html"><img src="<?= URL_ROOT ?>/public/images/R.jpg" class="product-image" alt=""></a>
            <a href="single.html">
                <h1>Đồ chơi búp bê</h1>
            </a>
            <p class="price">400,000 VND</p>
            <p><button>Thêm vào giỏ</button></p>
        </div>
    </div>
    <?php require APP_ROOT . '/views/inc/footer.php'; ?>
    <script>
        const selectElement = document.querySelector('.search');

        selectElement.addEventListener('change', (event) => {
            document.getElementsByClassName(".search").href = document.getElementsByClassName(".search").href + event.target.value;
        });
    </script>
</body>

</html>