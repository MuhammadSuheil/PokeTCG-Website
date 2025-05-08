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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="<?= $theme ?>">
<div class="header-container">
    <div class="title-count">
        <h1>POKETCG</h1>
        <p>#1 POKEMON TCG STORE</p>
        <p>Welcome, <?= htmlspecialchars($_SESSION['username']); ?> |
        <a href="index.php?logout=true" class="logout-link">Logout</a>
    </p>
    </div>
    <div class="form-tambah">
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
    </div>
</div>
<script>
    function updateFileName(input) {
        if (input.files.length > 0) {
            document.querySelector(".custom-file-upload").textContent = input.files[0].name;
        }
    }
</script>

<div class="container-parent">
    <div class="under-parent">
        <p>Total Cards In Stock: <strong><?= $productsObj->countProducts(); ?></strong></p>
        <div class="sort-button">
            <form method="POST" id="themeForm">
                <label class="switch">
                    <input type="checkbox" name="themeToggle" onchange="document.getElementById('themeForm').submit();" <?= (isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark') ? 'checked' : '' ?>>
                    <span class="slider round"></span>
                </label>
            </form>
            <a href="index.php?sort=name" class="sort-name">
                <button>Sort by Name (A-Z)</button>
            </a>
            <a href="index.php?sort=price" class="sort-price">
                <button>Sort by Price (Low-High)</button>
            </a>
        </div>
    </div>
    <div class="container">
        <div class="search-container">
            <div class="search-icon">
                <i class="fa fa-search" aria-hidden="true"></i>
            </div>
            <input type="input" id="search-item" placeholder="Cari barang">
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
                            <div class="edit-button">
                                <a href="edit.php?id=<?= $product['id']; ?>" class="edit-button">
                                    <button>edit</button>
                                </a>
                            </div>
                            <div class="remove-button">
                                <a class="remove-button" href="index.php?remove=<?= $product['id']; ?>" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                    <button>remove</button>
                                </a>
                            </div>
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
    <h3>Proyek dibuat untuk UTS Pemrograman Web II</h3>
    <p>Muhammad Suheil Ichma Putra_09021382328142</p>
</footer>
<script src="js/jQuery.js"></script>
</html>
