<?php

require_once 'connessioneDB.php';

// Esegui la query per ottenere le segnalazioni
$sql = "SELECT * FROM segnalazioni";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Ciclo su ogni segnalazione per generare l'HTML
    while($row = $result->fetch_assoc()) {
        // Stampa l'HTML con i dati della segnalazione
        echo "<div class='segnalazione'>";

        echo "<div class='barraSegnalazione'>";
        echo "<h4><span id='completamento'>" . $row["stato"] . "</span></h4>";
        echo "</div>";

        echo "<h4><span id='descrizione'>" . $row["descrizione"] . "</span></h4>";

        // Aggiungi un bottone per i dettagli, passando l'id della segnalazione
        echo "<button type='button' onclick='dettagliSegnalazione()' class='defaultButton'>Dettagli..</button>";

        echo "</div>";
    }
} else {
    echo "gay.";
    ;
}

// Chiudi la connessione
$conn->close();
?>
