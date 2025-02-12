<?php

require_once 'conn_db_SK.php';

// Ottiene l'ID della segnalazione dalla richiesta GET
$id = $_GET['id'];

// Prepara la query SQL
$sql = "SELECT * FROM segnalazioni WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se ci sono risultati
if ($result->num_rows > 0) {
    // Output dei dati di ogni riga
    while($row = $result->fetch_assoc()) {


        echo "ID: " . $row["id"]. " - Titolo: " . $row["titolo"]. " - Dettagli: " . $row["dettagli"]. "<br>";

        
    }
} else {
    echo "Nessuna segnalazione trovata.";
}

// Chiude la connessione
$conn->close();
?>
