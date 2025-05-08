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

$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter a username.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["email"]))) {
        $email_err = "Please enter an email.";
    } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
        $email_err = "Please enter a valid email address.";
    } else {
        $email = trim($_POST["email"]);
    }
    
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter a password.";     
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Password must have at least 6 characters.";
    } else {
        $password = trim($_POST["password"]);
    }
    
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password.";     
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
    
    if (empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)) {
        $user = new User($conn);

        if ($user->register($username, $email, $password)) {
            header("location: login.php?registration=success");
            exit();
        } else {
            echo "Something went wrong. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - PokeTCG</title>
    <link rel="stylesheet" href="../styles/styleRegister.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="header-container">
        <div class="title-count">
            <h1>POKETCG</h1>
            <p>#1 POKEMON TCG STORE</p>
        </div>
    </div>
    
    <div class="container">
        <div class="register-form">
            <h2>Sign Up</h2>
            <p>Please fill this form to create an account.</p>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Username</label><br>
                    <input type="text" name="username" value="<?php echo $username; ?>"><br>
                    <span class="error"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Email</label><br>
                    <input type="email" name="email" value="<?php echo $email; ?>"><br>
                    <span class="error"><?php echo $email_err; ?></span>
                </div>    
                <div class="form-group">
                    <label>Password</label><br>
                    <input type="password" name="password"><br>
                    <span class="error"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label><br>
                    <input type="password" name="confirm_password">
                    <span class="error"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="form-button">
                    <button type="submit">Register</button>
                </div>
                <p>Already have an account? <a href="login.php">Login here</a>.</p>
            </form>
        </div>    
    </div>
</body>
</html>