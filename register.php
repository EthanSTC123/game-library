<?php
# LOADS THE CONNECTION TO THE DATABASE
require_once 'includes/config.php';

$errors = [];
$success = "";

# Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    # Captures what the user has typed in
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

# Verify reCAPTCHA
    # Insert your reCAPTCHA secret key here
    $recaptcha_secret = "";
    $recaptcha_response = $_POST['g-recaptcha-response'];
    $verfiy_url = "https://www.google.com/recaptcha/api/siteverify?secret=$recaptcha_secret&response=$recaptcha_response";

    $response = file_get_contents($verfiy_url);
    $response_data = json_decode($response);

    if (!$response_data->success) {
        $errors[] = "Please complete the captcha verification.";
    }

# Makes sure all the fields are filled in and passwords match
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $errors[] = "All of the above fields are required.";
    } else if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

# Encrypts the password and stores the user in the database
    if (empty($errors)) {
          $hashed_password = password_hash($password, PASSWORD_DEFAULT);

          $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
          $stmt = mysqli_prepare($conn, $sql);
          mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);

          try {
              if (mysqli_stmt_execute($stmt)) {
                  $success = "Registration has been successful! You can now login.";
              } else {
                  $errors[] = "Username or email already exists";
              }
          } catch (Exception $e) {
              $errors[] = "An error occurred during registration. Please try again.";
          }
      }
}

require_once 'vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

echo $twig->render('register.twig', [
    'errors' => $errors,
    'success' => $success
]);

?>