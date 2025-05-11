<?php
session_start();
include 'classes/Product.php';

if (!isset($_SESSION['username'])) {
    header("Location: auth/login.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: auth/login.php");
    exit();
}

$productsObj = new Product();

if (isset($_GET['remove']) && is_numeric($_GET['remove'])) {
    $index = (int) $_GET['remove'];
    $productsObj->removeProduct($index);
    $products = $productsObj->getProducts(); 
    header("Location: index.php");
    exit();
}

$sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'name';
$products = $productsObj->getProducts($sortBy);

// $sortBy = isset($_GET['sort']) ? $_GET['sort'] : 'price';
// $products = $products->getProducts($sortBy);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['themeToggle'])) {
        setcookie('theme', 'dark', time() + (86400 * 30), "/"); 
    } else {
        setcookie('theme', 'light', time() + (86400 * 30), "/");
    }
    header("Location: " . $_SERVER['PHP_SELF']); 
    exit;
}

$theme = isset($_COOKIE['theme']) ? $_COOKIE['theme'] : 'light';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POKETCG</title>
    <link rel="stylesheet" href="styles/styleIndex.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="assets/logoPoke.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/6ed949fe3b.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="<?= $theme ?>">
<div class="header-container">
    <div class="title">
        <div class="logo">
            <img src="assets/logoPoke.png" alt="">
        </div>
        <div class="logo-text">
            <h1>POKETCG</h1>
            <p>#1 POKEMON TCG STORE</p>
        </div>
    </p>
    </div>
    <div class="right-header">
        <form method="POST" id="themeForm">
            <label class="switch">
                <input type="checkbox" name="themeToggle" onchange="document.getElementById('themeForm').submit();" <?= (isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark') ? 'checked' : '' ?>>
                <span class="slider round"></span>
            </label>
        </form>
        <p>Welcome, <?= htmlspecialchars($_SESSION['username']); ?> |
        <a href="index.php?logout=true" class="logout-link">Logout</a>
        <?php if ($_SESSION['role'] === 'admin'): ?>
        <div class="form-tambah">
            <button id= "form-tambah">Add Product</button>
        </div>
        <div class="tambah-produk" id="tambah-produk">
            <form action="insert.php" method="POST" enctype="multipart/form-data">
                <label>Name</label>
                <input type="text" name="name" placeholder="Nama Produk" required>
                <label>Description</label>
                <input type="text" name="description" placeholder="Deskripsi" required>
                <label>Price</label>
                <input type="number" name="price" placeholder="Harga" required>
                <label>Image</label>
                <label for="file-upload" class="custom-file-upload">Upload</label>
                <input type="file" name="imageFile" accept="image/*" placeholder="Image" id="file-upload" onchange="updateFileName(this)" required>
                <button type="submit">Add Product</button>
            </form>
            <button id= "form-close">Close</button>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function updateFileName(input) {
        if (input.files.length > 0) {
            document.querySelector(".custom-file-upload").textContent = input.files[0].name;
        }
    }
</script>

<div class="hero">
    <div class="carousel-container">
        <div class="carousel">
            <div class="carousel-item active">
                <img src="assets/SurgingSpark.png" alt="Promo 1">
            </div>
            <div class="carousel-item">
                <img src="assets/darkFantom.jpg" alt="Promo 2">
            </div>
            <div class="carousel-item">
                <img src="assets/PrismaticEvoBanner.jpg" alt="Promo 3">
            </div>
        </div>
            <button class="carousel-prev">
                <i class="fa-solid fa-angle-left"></i>
            </button>
            <button class="carousel-next">
                <i class="fa-solid fa-angle-right"></i>
            </button>
                
            <div class="carousel-indicators">
                <span class="indicator active" data-index="0"></span>
                <span class="indicator" data-index="1"></span>
                <span class="indicator" data-index="2"></span>
            </div>
    </div>
</div>
<div class="container-parent">
    <div class="container">
        <div class="search-and-sort">
            <div class="search-container">
                <div class="search-icon">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </div>
                <input type="input" id="search-item" placeholder="Cari barang">
            </div>
            <div class="sort-button">
                <ul>
                    <li>
                        <i class="fa-solid fa-sort"></i>
                        Sort by
                        <ul class="sort-dropdown">
                            <li><a href="index.php?sort=name" class="sort-name">Sort by Name</a></li>
                            <li><a href="index.php?sort=price" class="sort-price">Sort by Price</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="under-parent">
            <p>Total Cards In Stock: <strong><?= $productsObj->countProducts(); ?></strong></p>
        </div>
        <div class="product-list">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $index => $product): ?>
                    <div class="product" data-name="<?= strtolower($product['name']); ?>">
                        <img src="uploads/<?= htmlspecialchars($product['image']); ?>" alt="">
                        <h2><?= htmlspecialchars($product['name']); ?></h2>
                        <p><?= htmlspecialchars($product['card_desc']); ?></p>
                        <p>Price Range: <strong>$<?= htmlspecialchars($product['price']); ?></strong></p>
                        <div class="buttons">
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <div class="edit-button">
                                <a href="edit.php?id=<?= $product['id']; ?>" class="edit-button">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                            </div>
                            <div class="remove-button">
                                <a class="remove-button" href="index.php?remove=<?= $product['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                    <i class="fa-solid fa-trash"></i>
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="buy-button">
                                <a href="buy.php?id=<?= $product['id']; ?>">
                                    <button>Beli</button>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Tidak ada produk yang tersedia.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</body>
<footer>
    <div class="footer-texts">
        <h3>Proyek dibuat untuk UAS Pemrograman Web II</h3>
        <p>Muhammad Suheil Ichma Putra_09021382328142</p>
    </div>
    <div class="social-media">
        <ul>
            <li>
                <a href="https://instagram.com/suheilputraa">
                    <i class="fa-brands fa-square-instagram"></i>
                    <p>@suheilputraa</p>
                </a>
            </li>
            <li>
                <a href="https://www.linkedin.com/in/muhammadsuheilichmaputra/">
                    <i class="fa-brands fa-linkedin"></i>
                    <p>Muhammad Suheil Ichma Putra</p>
                </a>
            </li>
            <li>
                <a href="https://github.com/MuhammadSuheil">
                    <i class="fa-brands fa-github"></i>
                    <p>MuhammadSuheil</p>
                </a>
            </li>
        </ul>
    
    </div>
</footer>
<script src="js/jQuery.js"></script>
<script src="js/script.js"></script>
</html>
