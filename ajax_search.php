<?php
session_start();
require_once 'includes/config.php';

#Logged in users only
if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit();
}

$user_id = $_SESSION['user_id'];
$term = trim($_GET['term'] ?? '');

#Need at least 2 characters to search
if (strlen($term) < 2) {
    echo json_encode([]);
    exit();
}

#game title suggestions
$sql = "SELECT DISTINCT title FROM games WHERE user_id = ? AND title LIKE ? LIMIT 5";
$stmt = mysqli_prepare($conn, $sql);
$search_term = "%$term%";
mysqli_stmt_bind_param($stmt, "is", $user_id, $search_term);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$suggestions = [];
while ($row = mysqli_fetch_assoc($result)) {
    $suggestions[] = $row['title'];
}
echo json_encode($suggestions);
?>