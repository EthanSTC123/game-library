<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'includes/config.php';

# Get all games for current user
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM games WHERE user_id = ? ORDER BY dates_added DESC";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

#convert the results to an array for Twig
$games = [];
while ($row = mysqli_fetch_assoc($result)) {
    $games[] = $row;
}
?>

<?php
#Load Twig
require_once 'vendor/autoload.php';
$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

#Render games list
echo $twig->render('games.twig', [
    'username' => $_SESSION['username'],
    'games' => $games
]);
?>
