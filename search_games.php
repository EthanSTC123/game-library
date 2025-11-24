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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Games - Game Library</title>
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
    <h1>Search Games</h1>

    <form method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="title" class="form-control" placeholder="Title" value="<?php echo isset($_GET['title']) ? htmlspecialchars($_GET['title']) : ''; ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="genre" class="form-control" placeholder="Genre" value="<?php echo isset($_GET['genre']) ? htmlspecialchars($_GET['genre']) : ''; ?>">
            </div>
            <div class="col-md-3">
                <input type="text" name="platform" class="form-control" placeholder="Platform" value="<?php echo isset($_GET['platform']) ? htmlspecialchars($_GET['platform']) : ''; ?>">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-control">
                    <option value="Backlog" <?php if(($_GET['status'] ?? '') == 'Backlog') echo 'selected'; ?>>Backlog</option>
                    <option value="Playing" <?php if(($_GET['status'] ?? '') == 'Playing') echo 'selected'; ?>>Playing</option>
                    <option value="Completed" <?php if(($_GET['status'] ?? '') == 'Completed') echo 'selected'; ?>>Completed</option>
                    <option value="Wishlist" <?php if(($_GET['status'] ?? '') == 'Wishlist') echo 'selected'; ?>>Wishlist</option>
                </select>
            </div>
        </div>
        <button type="submit" name="search" value="1" class="btn btn-primary mt-3">Search</button>
        <a href="search_games.php" class="btn btn-secondary mt-3">Clear</a>
    </form>


    <?php if ($searched): ?>
            <?php if (count($games) > 0): ?>
                  <p>Found <?php echo count($games); ?> game(s)</p>
                  <table class="table table-striped">
                      <thead class="table-dark">
                          <tr>
                              <th>Title</th>
                              <th>Genre</th>
                              <th>Platform</th>
                              <th>Status</th>
                              <th>Rating</th>
                          </tr>
                      </thead>
                      <tbody>
                          <?php foreach ($games as $game): ?>
                          <tr>
                              <td><?php echo htmlspecialchars($game['title']); ?></td>
                              <td><?php echo htmlspecialchars($game['genre'] ?: '-'); ?></td>
                              <td><?php echo htmlspecialchars($game['platform'] ?: '-'); ?></td>
                              <td><?php echo htmlspecialchars($game['status']); ?></td>
                              <td><?php echo $game['rating'] ?: '-'; ?></td>
                          </tr>
                          <?php endforeach; ?>
                      </tbody>
                  </table>
              <?php else: ?>
                  <div class="alert alert-warning">No games matching your search</div>
              <?php endif; ?>
          <?php endif; ?>
      </div>
  </body>
  </html>