<?php
session_start();
require_once("conn_db_SK.php");

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('Qualcosa è andato storto :(');</script>";
    header("Location: ../accedi.html");
    exit();
}

// Verifica che i dati siano stati inviati
if (empty($_POST['password']) || empty($_POST['Npassword'])) {
    echo "<script>alert('Compila tutti i campi richiesti.');</script>";
    header("Location: ../cambia_password.html");
    exit();
}

$password = $_POST['password'];
$nuova_password = $_POST['Npassword'];
$email = $_SESSION['email']; // Assumendo che l'email sia salvata nella sessione

// Prepara la query per ottenere i dati dell'utente
$sql = "SELECT id, nome, password, recupero_password FROM utenti WHERE email = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo "<script>alert('Errore nella preparazione della query.');</script>";
    exit();
}

$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 1) {
    $stmt->bind_result($id, $nome, $passwordHash, $recupero_password);
    $stmt->fetch();

    // Verifica la password attuale
    if (password_verify($password, $passwordHash)) {
        if ($recupero_password == 1) {
            $hashed_new_password = password_hash($nuova_password, PASSWORD_DEFAULT);
            $user_id = $_SESSION['user_id'];

            // Aggiorna la password e imposta `recupero_password = 0`
            $update_sql = "UPDATE utenti SET password = ?, recupero_password = 0 WHERE id = ?";
            $update_stmt = $conn->prepare($update_sql);

            if (!$update_stmt) {
                echo "<script>alert('Errore nella preparazione della query di aggiornamento.');</script>";
                exit();
            }

            $update_stmt->bind_param("si", $hashed_new_password, $user_id);
            $update_stmt->execute();

            echo "<script>alert('Password aggiornata! Ora puoi accedere normalmente.');</script>";
            session_destroy(); // Forza il logout
            header("Location: ../accedi.html");
            exit();
        } else {
            echo "<script>alert('Non è possibile aggiornare la password in questo momento.');</script>";
            header("Location: ../cambia_password.html");
            exit();
        }
    } else {
        echo "<script>alert('La password attuale non è corretta.');</script>";
        header("Location: ../cambia_password.html");
        exit();
    }
} else {
    echo "<script>alert('Utente non trovato.');</script>";
    header("Location: ../accedi.html");
    exit();
}
?>

