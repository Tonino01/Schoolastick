<?php
session_start(); // Avvia la sessione

date_default_timezone_set("Europe/Rome"); // Imposta il fuso orario

require_once("conn_db_SK.php"); // Collegamento al database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
    // Controlla se l'email esiste
    $stmt = $conn->prepare("SELECT id FROM utenti WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id);
        $stmt->fetch();

        // Salva l'id nella sessione
        $_SESSION['user_id'] = $user_id;

        // Genera un token univoco
        $token = bin2hex(random_bytes(16));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Salva il token e la scadenza nel database
        $stmt = $conn->prepare("INSERT INTO recupero_password (user_id, token, scadenza) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $token, $expiry);
        $stmt->execute();

        // Invia email con il link per il reset della password
        $subject = "Recupero Password Schoolastick";
        $message = "Clicca qui per cambiare la password:\n https://schoolastick.ittvive.it/cambia_password.php?token=$token\n\n";
        mail($email, $subject, $message, "From: no-reply@schoolastick.com");

        echo "Segui le istruzioni inviate alla tua email per cambiare la password!<br>";
        echo "Puoi chiudere la scheda.";
    } else {
        echo "Email non trovata!";
    }
}
?>
