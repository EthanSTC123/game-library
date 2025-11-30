<?php
session_start();

#Checks if user is logged in already
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

# Display gammes to dashboard
$popular_games = [
[
    'title' => 'Tekken 8',
    'genre' => 'Fighting',
    'platform' => 'PS5, Xbox Series X, PC',
    'release_date' => '2024-01-26'
],
[
    'title' => 'Elden Ring',
    'genre' => 'Action RPG',
    'platform' => 'PC',
    'release_date' => '2022-02-25'
],
[
          'title' => 'Red Dead Redemption 2',
          'genre' => 'Action-Adventure',
          'platform' => 'PC',
          'release_date' => '2018-10-26'
],
[
          'title' => 'Cyberpunk 2077',
          'genre' => 'RPG',
          'platform' => 'PC',
          'release_date' => '2020-12-10'
],
[
          'title' => 'Grand Theft Auto V',
          'genre' => 'Action-Adventure',
          'platform' => 'PC',
          'release_date' => '2013-09-17'
],
[
          'title' => 'Minecraft',
          'genre' => 'Sandbox',
          'platform' => 'PC',
          'release_date' => '2011-11-18'
]
  ];

#Loads Twig
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);

#Render dashboard
echo $twig->render('dashboard.twig', [
    'username' => $username
    ,'popular_games' => $popular_games
]);
?>
