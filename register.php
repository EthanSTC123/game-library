<?php
# LOADS THE CONNECTION TO THE DATABASE
require_once 'includes/config.php';

# Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    # Captures what the user has typed in
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

# Makes sure all the fields are filled in and passwords match
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = "All of the above fields are required.";

    } else if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

# Encrypts the password and stores the user in the database
     else {
          $hashed_password = password_hash($password, PASSWORD_DEFAULT);

          $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
          $stmt = mysqli_prepare($conn, $sql);
          mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);

          if (mysqli_stmt_execute($stmt)) {
              $success = "Registration successful! You can now login.";
          } else {
              $errors[] = "Username or email already exists";
          }
      }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Game Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <div class="container mt-5">
        <h1>Register</h1>

        <?php if (isset($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <?php echo htmlspecialchars($error); ?><br>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <label>Username:</label>
            <input type="text" name="username" class="form-control mb-2" required>

            <label>Email:</label>
            <input type="email" name="email" class="form-control mb-2" required>

            <label>Password:</label>
            <input type="password" name="password" class="form-control mb-2" required>

            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" class="form-control mb-3" required>

            <button type="submit" class="btn btn-primary">Register</button>
        </form>

        <p class="mt-3">Already have an account? <a href="login.php">Login here</a></p>
    </div>

</body>
</html>
