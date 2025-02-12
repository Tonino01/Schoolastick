<?php

  require_once 'conn_db_SK.php';

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descrizione = filter_input(INPUT_POST, 'descrizione', FILTER_SANITIZE_STRING);
    $luogo_id = filter_input(INPUT_POST, 'luogo_id', FILTER_VALIDATE_INT);
    $data_creazione = date("Y-m-d H:i:s"); // Data attuale

    if (!$descrizione || !$luogo_id) {
        die("Dati non validi.");
    }

    // Query per l'inserimento
    $sql = "INSERT INTO segnalazioni (descrizione, data_creazione, id_utente_crea, luogo_id) 
            VALUES (:descrizione, :data_creazione, :id_utente_crea, :luogo_id)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':descrizione', $descrizione);
    $stmt->bindParam(':data_creazione', $data_creazione);
    $stmt->bindParam(':id_utente_crea', $user_id);
    $stmt->bindParam(':luogo_id', $luogo_id);

    if ($stmt->execute()) {
        echo "Segnalazione inserita con successo!";
    } else {
        echo "Errore durante l'inserimento.";
    }
}

?>
