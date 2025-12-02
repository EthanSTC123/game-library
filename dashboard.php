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
    'release_date' => '2024-01-26',
    'image' => 'https://m.media-amazon.com/images/I/61F2ifXoz+L._AC_UF894,1000_QL80_.jpg'
],
[
    'title' => 'Elden Ring',
    'genre' => 'Action RPG',
    'platform' => 'PC',
    'release_date' => '2022-02-25',
    'image' => 'https://shared.fastly.steamstatic.com/store_item_assets/steam/apps/1245620/capsule_616x353.jpg?t=1748630546'
],
[
          'title' => 'Red Dead Redemption 2',
          'genre' => 'Action-Adventure',
          'platform' => 'PC',
          'release_date' => '2018-10-26',
          'image' => 'https://upload.wikimedia.org/wikipedia/en/4/44/Red_Dead_Redemption_II.jpg'

],
[
          'title' => 'Cyberpunk 2077',
          'genre' => 'RPG',
          'platform' => 'PC',
          'release_date' => '2020-12-10',
          'image' => 'https://preview.redd.it/is-cyberpunk-cover-art-based-on-blade-runners-v0-p99esbve7sf81.jpg?width=640&crop=smart&auto=webp&s=6e1adcdc4e6f39339f4c3334cae9ff280211f7fa'

],
[
          'title' => 'Grand Theft Auto V',
          'genre' => 'Action-Adventure',
          'platform' => 'PC',
          'release_date' => '2013-09-17',
          'image' => 'https://media.rockstargames.com/rockstargames/img/global/news/upload/actual_1364906194.jpg'
],
[
          'title' => 'Minecraft',
          'genre' => 'Sandbox',
          'platform' => 'PC',
          'release_date' => '2011-11-18',
            'image' => 'https://i.redd.it/4lv9qrcjjui71.jpg'
],
[
            'title' => 'The Witcher 3: Wild Hunt',
            'genre' => 'Action RPG',
            'platform' => 'PC',
            'release_date' => '2015-05-19',
            'image' => 'https://cdn.cloudflare.steamstatic.com/steam/apps/292030/capsule_616x353.jpg?t=1669827203'
],
[
            'title' => 'The Legend of Zelda: Breath of the Wild',
            'genre' => 'Action-Adventure',
            'platform' => 'Nintendo Switch',
            'release_date' => '2017-03-03',
            'image' => 'https://assets.lostgamerstatic.com/a241e069-37a1-464e-8382-aa164cb9624c.jpg'
],
[
            'title' => 'God of War (2018)',
            'genre' => 'Action-Adventure',
            'platform' => 'PS4, PC',
            'release_date' => '2018-04-20',
            'image' => 'https://image.api.playstation.com/vulcan/img/rnd/202011/1021/X3WIAh63yKhRRiMohLoJMeQu.png'
],

[
            'title' => 'Hades',
            'genre' => 'Roguelike',
            'platform' => 'PC',
            'release_date' => '2020-09-17',
            'image' => 'https://media.wired.com/photos/5f6cf5ec6f32a729dc0b3a89/master/w_1600%2Cc_limit/Culture_inline_Hades_PackArt.jpg'
],

[
            'title' => 'Among Us',
            'genre' => 'Party',
            'platform' => 'PC',
            'release_date' => '2018-06-15',
            'image' => 'https://m.media-amazon.com/images/M/MV5BODI3ODMyZTgtZDdjYS00ZGRlLTg5YjMtNDY2ZjZlODg2NzYyXkEyXkFqcGc@._V1_.jpg'
],

[
            'title' => 'Fortnite',
            'genre' => 'Battle Royale',
            'platform' => 'PC',
            'release_date' => '2017-07-21',
            'image' => 'https://i.redd.it/tkq453ttioq51.jpg'
],

[
            'title' => 'Apex Legends',
            'genre' => 'Battle Royale',
            'platform' => 'PC',
            'release_date' => '2019-02-04',
            'image' => 'https://exotique.com.mt/wp-content/uploads/2022/11/Apex-Legends-Champion-Edition-Nintendo-Switch.jpg'
],

[
            'title' => 'Call of Duty: Warzone',
            'genre' => 'Battle Royale',
            'platform' => 'PC',
            'release_date' => '2020-03-10',
            'image' => 'https://images.igdb.com/igdb/image/upload/t_cover_big_2x/co20o8.jpg'
],

[
            'title' => 'Valorant',
            'genre' => 'FPS',
            'platform' => 'PC',
            'release_date' => '2020-06-02',
            'image' => 'https://m.media-amazon.com/images/M/MV5BZmQwMjQ2ZTUtZmM5MC00MTdkLWIxYzgtODU1NzQ4Zjg4NmMxXkEyXkFqcGc@._V1_.jpg'
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
