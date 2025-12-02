<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $genre = $_POST['genre'] ?? '';
    $platform = $_POST['platform'] ?? "PC";
    $release_date = $_POST['release_date'] ?? null;
    $hours_played = $_POST['hours_played'] ?? null;
    $status = $_POST['status'] ?? 'Backlog';
    
    #checks if game already exists in the users library
    $check_sql = "SELECT id FROM games WHERE user_id = ? AND title = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($check_stmt, "is", $user_id, $title);
    mysqli_stmt_execute($check_stmt);
    $check_result = mysqli_stmt_get_result($check_stmt);

        if (mysqli_num_rows($check_result) > 0) {
            $errors[] = "Game already exists in your library.";
            header("Location: dashboard.php");
        exit(); 
}

    #Insert game into database
    $sql = "INSERT INTO games (user_id, title, genre, platform, release_date, hours_played, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "issssis", $user_id, $title, $genre, $platform, $release_date, $hours_played, $status);

    if (mysqli_stmt_execute($stmt)) {
        #This is successful redirects to the games page
        header("Location: games.php");
        exit();
    } else {
        #Error redirects back to dashboard
        $errors[] = "Error adding game. Please try again.";
    }
}
?>