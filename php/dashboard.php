<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h2>Benvenuto, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h2>
    <p>Email: <?php echo htmlspecialchars($_SESSION['user_email']); ?></p>
    <a href="logout.php">Esci</a>
</body>
</html>
