<?php

require_once("conn_db_SK.php");

// Recupero dati dal form
$nome = $_POST['nome'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm-password'];

// Controllo se le password coincidono
if ($password !== $confirm_password) {
    die("Errore: Le password non corrispondono. <br><a href='registra.html'>Torna indietro</a>");
}

// Controllo del dominio dell'email
$dominioConsentito = "@iisvittorioveneto.it";
if (!str_ends_with($email, $dominioConsentito)) {
    die("Errore: Devi usare un'email con dominio " . $dominioConsentito . "<br><a href='registra.html'>Torna indietro</a>");
}

// Verifica se l'email è già registrata
$sqlCheck = "SELECT id FROM utenti WHERE email = ?";
$checkStmt = $conn->prepare($sqlCheck);
$checkStmt->bind_param("s", $email);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    die("Errore: Questa email è già registrata. <br><a href='registra.html'>Torna indietro</a>");
}

// Criptare la password prima di salvarla
$passwordHash = password_hash($password, PASSWORD_DEFAULT);

// Inserimento nel database
$sql = "INSERT INTO utenti (nome, email, password) VALUES (?, ?, ?)";
$comando = $conn->prepare($sql);

if ($comando) {
    $comando->bind_param("sss", $nome, $email, $passwordHash);

    if ($comando->execute()) {
        header("Location: accedi.html"); // Reindirizzamento alla pagina successiva
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
