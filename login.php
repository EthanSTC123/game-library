<?php
session_start();
require_once 'includes/config.php';

$error = [];

# Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error[] = "All fields are required.";
    } else {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {

        # This is to find the user and check the password

        if (password_verify($password, $user['password'])){
            # The password is correct
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $error[] = "Invalid username or password.";
        }
    }
    else {
        $error[] = "Invalid username or password.";
    }
    }
}


#TWIG conversion

require_once 'vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

echo $twig->render('login.twig', [
    'errors' => $error
]);

?>
