<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_password = $_POST['new_password'];
    $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);
    $user_id = $_SESSION['user_id'];

    // Aggiorna la password e imposta `recupera_password = 0`
    $stmt = $conn->prepare("UPDATE utenti SET password = ?, recupera_password = 0 WHERE id = ?");
    $stmt->bind_param("si", $hashed_new_password, $user_id);
    $stmt->execute();

    echo "Password aggiornata! Ora puoi accedere normalmente.";
    session_destroy(); // Forza il logout
}
?>

<form action="cambia_password.php" method="POST">
    <input type="password" name="new_password" placeholder="Nuova Password" required>
    <button type="submit">Aggiorna Password</button>
</form>
