<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'includes/config.php';

# get all game ids from URL
if (isset($_GET['id'])) {
    $game_id = (int)$_GET['id'];
    $user_id = $_SESSION['user_id'];

    # Delete query
    $sql = "DELETE FROM games WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $game_id, $user_id);
    mysqli_stmt_execute($stmt);

    # Redirects to games list after deletion
    header("Location: games.php");
    exit();
} else {
    header("Location: games.php");
    exit();
}