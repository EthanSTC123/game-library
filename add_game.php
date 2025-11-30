<?php
session_start();

#Checks if user is logged in already
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $genre = trim($_POST['genre']);
    $platform = trim($_POST['platform']);
    $release_date = !empty($_POST['release_year']) ? (int)$_POST['release_year'] : null;
    $rating = !empty($_POST['rating']) ? (int)$_POST['rating'] : null;
    $hours_played = !empty($_POST['hours_played']) ? (float)$_POST['hours_played'] : 0.0;
    $status = $_POST['status'];

    $user_id = $_SESSION['user_id'];
    if (empty($title)) {
        $error = "Title is needed to add a game.";

    } else {
        $sql = "INSERT INTO games (user_id, title, genre, platform, release_date, rating, hours_played, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        # Data types: i - integer, s - string, ect.
        # Parameter binding
        mysqli_stmt_bind_param($stmt, "isssiids", $user_id, $title, $genre, $platform, $release_date, $rating, $hours_played, $status);


        if (mysqli_stmt_execute($stmt)) {
            # if successful u will be redirected to the games list.
            header("Location: games.php");
            $success = "Game has been added into your library.";
            exit();
        } else {
            $errors[] = "Error! Please try again and add a game.";
        }
    }
}

#Error handling
$errors = [];

if (isset($error)) {
    $errors[] = $error;
}

# Load Twig
require_once 'vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

echo $twig->render('add_game.twig', [
    'username' => $_SESSION['username'],
    'errors' => $errors
]);
?>