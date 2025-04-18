<?php
require "Database.php";

class Product{
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getProducts($orderBy = "name") {
        $allowedSort = ["name", "price"];
        if (!in_array($orderBy, $allowedSort)) {
            $orderBy = "name"; 
        }

        if ($orderBy === "price") {
            $query = "SELECT * FROM products ORDER BY CAST(price AS DECIMAL(10,2)) ASC";
        } else {
            $query = "SELECT * FROM products ORDER BY $orderBy ASC";
        }

        $result = $this->conn->query($query);
        $products = mysqli_fetch_all($result, MYSQLI_ASSOC);

        return $products;
    }

    public function countProducts() {
        $sql = "SELECT COUNT(*) AS total FROM products";
        $result = $this->conn->query($sql);

        if ($result) {
            $row = $result->fetch_assoc();
            return $row['total'];
        }
    }

    function addProduct($name, $description, $price, $imageFile) {
        $uploadDir = "uploads/";
        $imageExtension = pathinfo($imageFile['name'], PATHINFO_EXTENSION);
        $imageHash = hash('sha256', time() . $imageFile['name']);
        $hashedImageName = $imageHash . "." . $imageExtension;
        $uploadPath = $uploadDir . $hashedImageName;

        if (move_uploaded_file($imageFile['tmp_name'], $uploadPath)) {
            $stmt = $this->conn->prepare("INSERT INTO products (name, card_desc, price, image) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssds", $name, $description, $price, $hashedImageName);

            if ($stmt->execute()) {
                echo "Produk berhasil ditambahkan!";
            } else {
                echo "Error: " . $stmt->error;
            }
        } else {
            echo "Gagal upload gambar.";
        }
    }

    function removeProduct($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }
}
?>
