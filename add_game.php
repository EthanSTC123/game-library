<?php
session_start();

#Checks if user is logged in already
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $genre = trim($_POST['genre']);
    $platform = trim($_POST['platform']);
    $release_date = !empty($_POST['release_year']) ? (int)$_POST['release_year'] : null;
    $rating = !empty($_POST['rating']) ? (int)$_POST['rating'] : null;
    $hours_played = !empty($_POST['hours_played']) ? (float)$_POST['hours_played'] : 0.0;
    $status = $_POST['status'];

    $user_id = $_SESSION['user_id'];
    if (empty($title)) {
        $error = "Title is needed to add a game.";

    } else {
        $sql = "INSERT INTO games (user_id, title, genre, platform, release_date, rating, hours_played, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        # Data types: i - integer, s - string, ect.
        # Parameter binding
        mysqli_stmt_bind_param($stmt, "isssiids", $user_id, $title, $genre, $platform, $release_date, $rating, $hours_played, $status);


        if (mysqli_stmt_execute($stmt)) {
            # if successful u will be redirected to the games list.
            header("Location: games.php");
            $success = "Game has been added successfully!";
            exit();
        } else {
            $errors[] = "Error! Please try again and add a game.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Game - Game Library</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Game Library</a>
            <div>
                <a href="dashboard.php" class="btn btn-sm btn-outline-light me-2">Dashboard</a>
                <a href="games.php" class="btn btn-sm btn-outline-light me-2">My Games</a>
                <a href="search_games.php" class="btn btn-sm btn-outline-light me-2">Search</a>
                <a href="logout.php" class="btn btn-sm btn-outline-light">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Add a New Game</h1>
<?php
        if (isset($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <?php echo htmlspecialchars($error); ?><br>
                <?php endforeach; ?>
            </div>
<?php endif; ?>

        <form method="POST" action="">
            <label>Title:</label>
            <input type="text" name="title" class="form-control mb-2" required>

            <label>Genre:</label>
            <input type="text" name="genre" class="form-control mb-2">

            <label>Platform:</label>
            <input type="text" name="platform" class="form-control mb-2">

            <label>Release Date:</label>
            <input type="date" name="release_date" class="form-control mb-2">

            <label>Rating (1-10):</label>
            <input type="number" name="rating" min="1" max="10" class="form-control mb-2">

            <label>Hours Played:</label>
            <input type="number" step="0.1" name="hour_played" class="form-control mb-2">

            <label>Status:</label>
            <select name="status" class="form-control mb-3">
                <option value="Backlog">Backlog</option>
                <option value="Playing">Playing</option>
                <option value="Completed">Completed</option>
                <option value="Wishlist">Wishlist</option>
            </select>

            <label>Notes:</label>
            <textarea name="notes" class="form-control mb-3" rows="3"></textarea>

            <button type="submit" class="btn btn-primary">Add Game</button>
        </form>
    </div>

</body>
