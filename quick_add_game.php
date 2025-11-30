<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = $_GET['title'];
    $genre = $_GET['genre'] ?? '';
    $platform = $_GET['platform'] ?? "PC";
    $release_date = $_GET['release_date'] ?? null;

    # Insert the games 
    $sql = "INSERT INTO games (user_id, title, genre, platform, release_date) VALUES (?, ?, ?, ?, ?, 'Backlog')";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "issss", $user_id, $title, $genre, $platform, $release_date);

    if (mysqli_stmt_execute($stmt)) {
    # Successful - redirects to game page
        header("Location: games.php");
        exit();
    } else {
        #Eror - redirects back the the dhasboard with an error message
        header("Location: dashboard.php");
        exit(); }
        
    } else {
    # No game data was provided - redirects back to dashboard
    header("Location: dashboard.php");
    exit();
}
?>