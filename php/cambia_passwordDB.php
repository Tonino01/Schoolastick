<?php
session_start();
require_once("conn_db_SK.php");

// Verifica che il token sia presente nel GET
if (empty($_GET['token'])) {
    echo "<script>alert('Token mancante.');</script>";

    echo "errore con il link di recupero della password!<br>";
    echo "Puoi chiudere la scheda.";    
    exit();
}

$token = $_GET['token'];

// Verifica che i dati siano stati inviati
if (empty($_POST['password']) || empty($_POST['Rpassword'])) {
    echo "<script>alert('Compila tutti i campi richiesti.');</script>";
    header("Location: ../cambia_password.php?token=$token");
    exit();
}

$nuova_password = $_POST['password'];
$conferma_password = $_POST['Rpassword'];

// Confronta le due password
if ($nuova_password !== $conferma_password) {
    echo "<script>alert('Le password non coincidono.');</script>";
    header("Location: ../cambia_password.php?token=$token");
    exit();
}

// Verifica il token nel database
$token_sql = "SELECT user_id FROM recupero_password WHERE token = ?";
$token_stmt = $conn->prepare($token_sql);

if (!$token_stmt) {
    echo "<script>alert('Errore nella preparazione della query per il token.');</script>";
    exit();
}

$token_stmt->bind_param("s", $token);
$token_stmt->execute();
$token_result = $token_stmt->get_result();

if ($token_result->num_rows === 0) {
    echo "<script>alert('Token non valido o scaduto.');</script>";
    header("Location: ../cambia_password.php?token=$token");
    exit();
}

$row = $token_result->fetch_assoc();
$user_id = $row['user_id'];

// Hash della nuova password
$hashed_new_password = password_hash($nuova_password, PASSWORD_DEFAULT);

// Aggiorna la password nel database
$update_sql = "UPDATE utenti SET password = ? WHERE id = ?";
$update_stmt = $conn->prepare($update_sql);

if (!$update_stmt) {
    echo "<script>alert('Errore nella preparazione della query di aggiornamento.');</script>";
    exit();
}

$update_stmt->bind_param("si", $hashed_new_password, $user_id);
$update_stmt->execute();

if ($update_stmt->affected_rows > 0) {
    // Elimina il token dalla tabella recupera_password
    $delete_token_sql = "DELETE FROM recupero_password WHERE user_id = ?";
    $delete_token_stmt = $conn->prepare($delete_token_sql);

    if ($delete_token_stmt) {
        $delete_token_stmt->bind_param("i", $user_id);
        $delete_token_stmt->execute();
    }

    echo "<script>alert('Password aggiornata con successo!');</script>";
    header("Location: ../accedi.html");
    exit();
} else {
    echo "<script>alert('Errore durante l'aggiornamento della password.');</script>";
    header("Location: ../cambia_password.php?token=$token");
    exit();
}
?>

