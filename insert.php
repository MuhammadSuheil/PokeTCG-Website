<?php
require_once "classes/Product.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $products = new Product();
    $products->addProduct($_POST['name'], $_POST['description'], $_POST['price'], $_FILES['imageFile']);
    header("Location: index.php");
    exit();
}
?>