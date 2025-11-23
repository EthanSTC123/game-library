<?php
session_start();

#Checks if user is logged in already
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
#Loads Twig
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

#Render dashboard
echo $twig->render('dashboard.twig', [
    'username' => $username
]);
?>
