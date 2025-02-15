<?php

require_once("conn_db_SK.php"); // Collegamento al database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    
    // Controlla se l'email esiste
    $stmt = $conn->prepare("SELECT id FROM utenti WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Genera password temporanea
        $temp_password = bin2hex(random_bytes(4)); // 8 caratteri casuali
        $hashed_password = password_hash($temp_password, PASSWORD_BCRYPT);

        // Imposta recupera_password = 1 e aggiorna la password temporanea
        $update_stmt = $conn->prepare("UPDATE utenti SET password = ?, 
                                        recupero_password = 1 
                                        WHERE email = ?");
        $update_stmt->bind_param("ss", $hashed_password, $email);
        $update_stmt->execute();

        // Invia email con la password temporanea
        $subject = "Recupero Password";
        $message = "La tua password temporanea è: $temp_password\nAccedi e cambiala subito.";
        mail($email, $subject, $message, "From: no-reply@tuodominio.com");

        echo "Email inviata! Controlla la tua casella di posta.";
    } else {
        echo "Email non trovata!";
    }
}
?>
