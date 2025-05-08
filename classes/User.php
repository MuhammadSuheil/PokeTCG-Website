<?php
// User.php - User class for handling authentication and user management

class User {
    private $conn;
    private $id;
    private $username;
    private $email;
    private $password;
    private $created_at;

    // Constructor with database connection
    public function __construct($db = null) {
        if ($db !== null) {
            $this->conn = $db;
        } else {
            // Include database connection if not provided
            require_once "config/db.php";
            global $conn;
            $this->conn = $conn;
        }
    }

    // Register a new user
    public function register($username, $email, $password) {
        // Sanitize input
        $this->username = htmlspecialchars(strip_tags($username));
        $this->email = htmlspecialchars(strip_tags($email));
        $this->password = password_hash($password, PASSWORD_BCRYPT);
    
        // Check if username or email already exists
        if ($this->usernameExists()) {
            echo "Username already exists.<br>";
            return false;
        }
    
        if ($this->emailExists()) {
            echo "Email already exists.<br>";
            return false;
        }
    
        // Insert query
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        
        if (!$stmt) {
            echo "Prepare failed: " . $this->conn->error . "<br>";
            return false;
        }
    
        // Bind parameters
        $stmt->bind_param("sss", $this->username, $this->email, $this->password);
        
        // Execute query
        if ($stmt->execute()) {
            return true;
        } else {
            echo "Execute failed: " . $stmt->error . "<br>";
            return false;
        }
    }
    

    // Login user
    public function login($username, $password) {
        // Sanitize input
        $this->username = htmlspecialchars(strip_tags($username));
        
        // Query to check if username exists
        $query = "SELECT id, username, email, password, created_at FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        
        // Bind parameters
        $stmt->bind_param("s", $this->username);
        
        // Execute query
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Check if user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Store user data
                $this->id = $user['id'];
                $this->username = $user['username'];
                $this->email = $user['email'];
                $this->created_at = $user['created_at'];
                
                return true;
            }
        }
        
        return false;
    }

    // Check if username already exists
    private function usernameExists() {
        $query = "SELECT id FROM users WHERE username = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0;
    }

    // Check if email already exists
    private function emailExists() {
        $query = "SELECT id FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $this->email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->num_rows > 0;
    }

    // Get user ID
    public function getId() {
        return $this->id;
    }

    // Get username
    public function getUsername() {
        return $this->username;
    }

    // Get email
    public function getEmail() {
        return $this->email;
    }

    // Get creation date
    public function getCreatedAt() {
        return $this->created_at;
    }
}
?>