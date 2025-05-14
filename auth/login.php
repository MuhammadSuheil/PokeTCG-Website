<?php
session_start();

if (isset($_SESSION['username'])) {
    header("location: ../index.php");
    exit;
}

require_once "../classes/Database.php";
$db = new Database();
$conn = $db->getConnection();

require_once "../classes/User.php";
$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
        $user = new User($conn);
        

        if ($user->login($username, $password)) {
            $_SESSION["username"] = $user->getUsername();
            $_SESSION["id"] = $user->getId();
            $_SESSION["role"] = $user->getRole();
            
            header("location: ../index.php");
            exit();
        } 
        else {
            $login_err = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PokeTCG</title>
    <link rel="stylesheet" href="../styles/styleRegister.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="title">
            <div class="logo">
                <img src="../assets/logoPoke.png" alt="">
            </div>
            <div class="logo-text">
                <h1>POKETCG</h1>
                <p>#1 POKEMON TCG STORE</p>
            </div>
        </div>
        <div class="register-form">
            <div class="register-text">
                <h2>Login</h2>
                <p>Please fill in your credentials to login.</p>
            </div>
            <?php 
            if (!empty($login_err)) {
                echo '<div class="alert alert-danger">' . $login_err . '</div>';
            }        
            ?>

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" value="<?php echo $username; ?>">
                    <span class="error"><?php echo $username_err; ?></span>
                    <label>Password</label>
                    <input type="password" name="password">
                    <span class="error"><?php echo $password_err; ?></span>
                    <div class="form-button">
                        <button type="submit">Login</button>
                    </div>
                </div>
            </form>
        </div>
        <p>Don't have an account? <a id="direct-login" href="register.php">Sign up now</a>.</p>
    </div>
</body>
</html>