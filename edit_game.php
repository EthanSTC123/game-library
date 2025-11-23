<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once 'includes/config.php';

# Handle form submissions (this is when the user clicks the update game button)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$game_id = (int)$_POST['game_id'];
    $title = trim($_POST['title']);
    $genre = trim($_POST['genre']);
    $platform = trim($_POST['platform']);
    $release_date = !empty($_POST['release_year']) ? (int)$_POST['release_year'] : null;
    $rating = !empty($_POST['rating']) ? (int)$_POST['rating'] : null;
    $hours_played = !empty($_POST['hours_played']) ? (float)$_POST['hours_played'] : 0.0;
    $status = $_POST['status'];
    $user_id = $_SESSION['user_id'];

    $sql = "UPDATE games SET title=?, genre=?, platform=?, release_date=?, rating=?, hours_played=?, status=?, notes=? WHERE id=? AND user_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssidssii", $title, $genre, $platform, $release_date, $rating, $hours_played, $status, $_POST['notes'], $game_id, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: games.php");
        exit();
    } else {
        $errors[] = "AN error has eccured trying to update the ganme. Please try again.";
    }
}

# Getting the game data from the database

if (isset($_GET['id'])) {
    $game_id = (int)$_GET['id'];
    $user_id = $_SESSION['user_id'];

    $sql = "SELECT * FROM games WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $game_id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($game = mysqli_fetch_assoc($result)) {
        // Game found, proceed to show the edit form
    } else {
        header("Location: games.php");
        exit();
    }
} else {
    header("Location: games.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Game</title>
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
                <a href="logout.php" class="btn btn-sm btn-outline-light">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h1>Edit Game</h1>

        <?php if (isset($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <?php echo htmlspecialchars($error); ?><br>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <input type="hidden" name="game_id" value="<?php echo htmlspecialchars($game['id']); ?>">

            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($game['title']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <input type="text" class="form-control" id="genre" name="genre" value="<?php echo htmlspecialchars($game['genre']); ?>">
            </div>

            <div class="mb-3">
                <label for="platform" class="form-label">Platform</label>
                <input type="text" class="form-control" id="platform" name="platform" value="<?php echo htmlspecialchars($game['platform']); ?>">
            </div>

            <div class="mb-3">
                <label for="release_year" class="form-label


">Release Year</label>
            <input type="date" name="release_date" class="from-control mb-3 " value="<?php echo $game['release_date']; ?>">

            <label>Rating 1-10:</label>
            <input type="number" name="rating" class="form-control mb-2" min="1" max="10" value="<?php echo $game['rating']; ?>">

            <label>Hours PLayed</label>
            <input type="number" step="0.1" name="hours_played" class="form-control mb-2" value="<?php echo $game['hours_played']; ?>">

            <label>Status:</label>
            <select name="status" class="form-control mb-3">
                <option value="Backlog" <?php if ($game['status'] == 'Backlog') echo 'selected'; ?>>Backlog</option>
                <option value="Playing" <?php if ($game['status'] == 'Playing') echo 'selected'; ?>>Playing</option>
                <option value="Completed" <?php if ($game['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                <option value="Wishlist" <?php if ($game['status'] == 'Wishlist') echo 'selected'; ?>>Wishlist</option>
            </select>

            <button type="submit" class="btn btn-primary">Update Game</button>
            <a href="games.php" class="btn btn-secondary ms-2">Cancel</a>
        </form>
    </div>
</body>
</html>