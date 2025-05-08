<?php
include('classes/Product.php');
require_once('classes/Database.php');

$database = new Database();
$conn = $database->getConnection();

$id = ($_GET['id']); 
$sql = "SELECT * FROM products WHERE id = $id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Card</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles/styleEdit.css">
</head>
<body>
    <div class="edit-container">
        <h2>Edit Product</h2>
        <form action="update.php" method="post" enctype="multipart/form-data">
            <div class="form-container">
                <div class="text-container">
                    <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                    <p>Nama</p>
                    <input type="text" name="name" value="<?php echo $user['name']; ?>" required>
                    <p>Description</p>
                    <input type="text" name="description" value="<?php echo $user['card_desc']; ?>" required>
                    <p>Price</p>
                    <input type="number" name="price" value="<?php echo $user['price']; ?>" required>
                </div>
                    <div class="image-container">
                    <p>Current Image</p>
                    <img src="uploads/<?php echo htmlspecialchars($user['image']); ?>" alt="Product Image" width="150">
                    <p>Change Image</p>
                    <input type="file" name="image" value="<?php echo $user['image']; ?>" accept="image/*" >
                </div>
            </div>
            <button type="submit">Confirm</button>
        </form>
        <br>
        <a href="index.php">Kembali ke Daftar</a>
    </div>
</body>
</html>
