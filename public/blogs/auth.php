<?php
include_once 'DbConfig.php';
class Auth extends DbConfig
{
    public function __construct()
    {
        parent::__construct();
    }
    public function doLogin($email, $password)
    {
        session_start();
        # Validate email and password are not empty
        if (empty($email) || empty($password)) {
            return "All fields are required!";
        }
        # Prepare the SQL statement to prevent SQL injection
        $stmt = $this->conn->prepare("SELECT * FROM adminusertable WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($password === $row['password']) { 
                # Ideally, use password hashing
                # Set session variables for logged in user
                $_SESSION['email'] = $row['email'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['mobile'] = $row['mobile'];
                $_SESSION['id'] = $row['id'];
                # Successful login
                return true; 
            } else {
                return "Invalid password!";
            }
        } else {
            return "Invalid email!";
        }
    }
}

# Handling form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $auth = new Auth();
    $loginResult = $auth->doLogin($email, $password);
    if ($loginResult === true) {
        header("Location: admin/list_blog.php"); 
        #Redirect on success
        exit();
    } else {
        die;
         header("Location: login.php?error=" . urlencode($loginResult)); 
        # Redirect on failure with error
        exit();
    }
}
?>
