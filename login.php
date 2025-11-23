<?php
session_start();
require_once 'includes/config.php';

# Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $errors[] = "All fields are required.";
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
            $errors[] = "Invalid username or password.";
        }
    }
    else {
        $errors[] = "Invalid username or password.";
    }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Game Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="container mt-5">
        <h1>Login</h1>

        <?php if (isset($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <?php echo htmlspecialchars($error); ?><br>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" class="form-control mb-2" required>

            <label>Password:</label>
            <input type="password" name="password" class="form-control mb-3" required>

            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <p class="mt-3">Haven't created an account? <a href="register.php">Register here!</a></p>
    </div>

</body>
</html>
