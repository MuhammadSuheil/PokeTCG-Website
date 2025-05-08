<?php
include('classes/Database.php');

$database = new Database(); 
$conn = $database->getConnection(); 

$id = $_POST['id'];
$name = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];

if (!empty($_FILES['image']['name'])) {
    $imageName = $_FILES['image']['name'];
    $imageTmp = $_FILES['image']['tmp_name'];
    $imageExtension = pathinfo($imageName, PATHINFO_EXTENSION);
    $hashedImageName = hash('sha256', time() . $imageName) . '.' . $imageExtension;
    $uploadPath = "uploads/" . $hashedImageName;
    
    if (move_uploaded_file($imageTmp, $uploadPath)) {
        $sql = "UPDATE products SET name=?, card_desc=?, price=?, image=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssi", $name, $description, $price, $hashedImageName, $id);
    } else {
        echo "Gagal mengunggah gambar.";
        exit();
    }
} else {
    $sql = "UPDATE products SET name=?, card_desc=?, price=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $description, $price, $id);
}

if ($stmt->execute()) {
    header("Location: index.php");
} else {
    echo "Error: " . $stmt->error;
}
?>
