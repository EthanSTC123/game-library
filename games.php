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
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Games - Game Library</title>


    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <!-- Simple Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">Game Library</a>
            <div>
                <a href="dashboard.php" class="btn btn-sm btn-outline-light me-2">Dashboard</a>
                <a href="search_games.php" class="btn btn-sm btn-outline-light me-2">Search</a>
                <a href="add_game.php" class="btn btn-sm btn-outline-light me-2">Add Game</a>
                <a href="logout.php" class="btn btn-sm btn-outline-light">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <h1>My Games</h1>
        <p>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

        <a href="add_game.php" class="btn btn-primary mb-3">Add New Game</a>

        <?php if (mysqli_num_rows($result) > 0): ?>

            <!-- Games Table -->
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Genre</th>
                        <th>Platform</th>
                        <th>Release Date</th>
                        <th>Rating</th>
                        <th>Hours Played</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($game = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($game['title']); ?></td>
                        <td><?php echo htmlspecialchars($game['genre'] ?: '-'); ?></td>
                        <td><?php echo htmlspecialchars($game['platform'] ?: '-'); ?></td>
                        <td><?php echo $game['release_date'] ? htmlspecialchars($game['release_date']) : '-'; ?></td>
                        <td><?php echo $game['rating'] ?: '-'; ?></td>
                        <td><?php echo $game['hours_played'] ? htmlspecialchars($game['hours_played']) : '0'; ?></td>
                        <td>
                            <?php
                            $badge = 'bg-secondary';
                            if ($game['status'] == 'Completed') $badge = 'bg-success';
                            elseif ($game['status'] == 'Playing') $badge = 'bg-primary';
                            elseif ($game['status'] == 'Wishlist') $badge = 'bg-info';
                            ?>
                            <span class="badge <?php echo $badge; ?>">
                                <?php echo htmlspecialchars($game['status']); ?>
                            </span>
                        </td>
                        <td>
                            <a href="edit_game.php?id=<?php echo $game['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete_game.php?id=<?php echo $game['id']; ?>"
                               class="btn btn-sm btn-danger"
                               onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="alert alert-info mt-3">
                <strong>Total Games:</strong> <?php echo mysqli_num_rows($result); ?>
            </div>

        <?php else: ?>

            <!-- No Games Message -->
            <div class="alert alert-warning">
                <h4>No games in your library yet!</h4>
                <p>Click "Add New Game" to start building your collection.</p>
            </div>

        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
