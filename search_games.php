<?php
session_start();
require_once 'includes/config.php'; 

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$games = [];
$searched = false;


#Checks if a search query has been provided and set.
if (isset($_GET['search'])) {
    $searched = true;

    #Gets search parameters
    $title = trim($_GET['title']);
    $genre = trim($_GET['genre']);
    $platform = trim($_GET['platform']);
    $status = trim($_GET['status']);

    #Builds the base SQL query
    $sql = "SELECT * FROM games WHERE user_id = ?";
    $params = [$user_id];
    $types = "i";

    #Adds the conditions for each field if has been provided
    if (!empty($title)) {
        $sql .= " AND title LIKE ?";
        $params[] = "%$title%";
        $types .= "s";
    }
    if (!empty($genre)) {
        $sql .= " AND genre LIKE ?";
        $params[] = "%$genre%";
        $types .= "s";
    }
    if (!empty($platform)) {
        $sql .= " AND platform LIKE ?";
        $params[] = "%$platform%";
        $types .= "s";
    }
    if (!empty($status)) {
        $sql .= " AND status LIKE ?";
        $params[] = "%$status%";
        $types .= "s";
    }

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        $games[] = $row;
    }
}

$search_params = [
    'title' => $title ?? '',
    'genre' => $genre ?? '',
    'platform' => $platform ?? '',
    'status' => $status ?? ''
];

#Load Twig
require_once 'vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

echo $twig->render('search_games.twig', [
    'games' => $games,
    'searched' => $searched,
    'search_params' => $search_params
]);
?>