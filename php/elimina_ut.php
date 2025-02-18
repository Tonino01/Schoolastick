<?php

session_start();

require_once("conn_db_SK.php"); // Collegamento al database

$id = isset($_SESSION['user_modificare_id']) ? $_SESSION['user_modificare_id'] : 'null';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recupera l'ID dell'utente da eliminare

    // SQL per eliminare l'utente
    $sql = "DELETE FROM utenti WHERE id = ?";

    // Prepara la query
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id); // "i" indica un intero
        $stmt->execute();

        // Verifica se la riga è stata effettivamente eliminata
        if ($stmt->affected_rows > 0) {
            echo "Utente eliminato con successo.";
        } else {
            echo "Errore durante l'eliminazione.";
        }

        $stmt->close();
    }

    // Chiudi la connessione
    $conn->close();
}
?>
