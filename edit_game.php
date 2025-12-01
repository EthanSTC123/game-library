<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'includes/config.php';

# Handle form submissions (this is when the user clicks the update game button)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$game_id = (int)$_POST['game_id'];
    $title = trim($_POST['title']);
    $genre = trim($_POST['genre']);
    $platform = trim($_POST['platform']);
    $release_date = !empty($_POST['release_year']) ? (int)$_POST['release_year'] : null;
    $rating = !empty($_POST['rating']) ? (int)$_POST['rating'] : null;
    $hours_played = !empty($_POST['hours_played']) ? (float)$_POST['hours_played'] : 0.0;
    $status = $_POST['status'];
    $user_id = $_SESSION['user_id'];

    $sql = "UPDATE games SET title=?, genre=?, platform=?, release_date=?, rating=?, hours_played=?, status=?, notes=? WHERE id=? AND user_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssidssii", $title, $genre, $platform, $release_date, $rating, $hours_played, $status, $_POST['notes'], $game_id, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: games.php");
        exit();
    } else {
        $errors[] = "AN error has eccured trying to update the ganme. Please try again.";
    }
}

# Getting the game data from the database

if (isset($_GET['id'])) {
    $game_id = (int)$_GET['id'];
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT * FROM games WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $game_id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($game = mysqli_fetch_assoc($result)) {
        // Game found, proceed to show the edit form
    } else {
        header("Location: games.php");
        exit();
    }
} else {
    header("Location: games.php");
    exit();
}
# Error handling
$errors = [];

# Load Twig
require_once 'vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

echo $twig->render('edit_game.twig', [
    'username' => $_SESSION['username'],
    'game' => $game,
    'errors' => $errors
]);
?>