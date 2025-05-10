<?php

require_once("conn_db_SK.php");

// Recupero dati dal form
$nome = $_SESSION["Rnome"];
$email = $_SESSION["Remail"];
$password = $_SESSION["Rpassword"];
$confirm_password = $_SESSION["Rconfirm-password"];

// Criptare la password prima di salvarla
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Inserimento nel database
$sql = "INSERT INTO utenti (nome, email, password) VALUES (?, ?, ?)";
$comando = $conn->prepare($sql);

if ($comando) {
    $comando->bind_param("sss", $nome, $email, $passwordHash);

    if ($comando->execute()) {
        
        header("Location: ../accedi.html"); // Reindirizzamento alla pagina successiva
        exit;
    } else {
        die("Errore nell'inserimento: " . $comando->error);
    }
} else {
    die("Errore nella preparazione della query");
}

// Chiudi connessioni
$checkStmt->close();
$comando->close();
$conn->close();

?>
