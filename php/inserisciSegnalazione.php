<?php
session_start();
require_once 'conn_db_SK.php'; // Assicurati che il file contenga la connessione MySQLi

if (!isset($_SESSION['user_id'])) {
    die("Accesso non autorizzato.");
}

$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descrizione = htmlspecialchars($_POST['descrizione'], ENT_QUOTES, 'UTF-8');
    $luogo_id = filter_input(INPUT_POST, 'luogo_id', FILTER_VALIDATE_INT);
    $data_creazione = date("Y-m-d H:i:s");

    if (!$descrizione || !$luogo_id) {
        die("Dati non validi.");
    }

    if (!$conn) {
        die("Errore: Connessione al database non riuscita.");
    }

    // Query corretta con 4 parametri
    $sql = "INSERT INTO segnalazioni (descrizione, data_creazione, id_utente_crea, luogo_id) 
            VALUES (?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Assicuriamoci che ci siano 4 parametri (s = stringa, s = stringa, i = intero, i = intero)
        $stmt->bind_param("ssii", $descrizione, $data_creazione, $user_id, $luogo_id);

        if ($stmt->execute()) {
            echo "Segnalazione inserita con successo!";
        } else {
            echo "Errore durante l'inserimento: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Errore nella preparazione della query: " . $conn->error;
    }
}
?>
