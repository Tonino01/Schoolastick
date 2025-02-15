<?php
require_once 'conn_db_SK.php';

// Ottieni il parametro di ricerca dal POST
$parametroRicerca = $_POST['parametroRicerca'];

// Costruisci la query in base al parametro di ricerca
$sql = "SELECT * FROM segnalazioni WHERE descrizione LIKE ?";
$stmt = $conn->prepare($sql);

// Aggiungi il parametro di ricerca con i caratteri jolly per la ricerca parziale
$searchTerm = "%" . $parametroRicerca . "%";
$stmt->bind_param("s", $searchTerm);

// Esegui la query
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Ciclo su ogni segnalazione per generare l'HTML
    while($row = $result->fetch_assoc()) {
        // Stampa l'HTML con i dati della segnalazione
        echo "<div class='segnalazione'>";

        echo "<div class='barraSegnalazione'>";
        echo "<h4>[<span id = 'idSegnalazione'>" . $row["id"] . "</span>]<span id='completamento'>" . $row["stato"] . "</span></h4>";
        echo "</div>";

        echo "<h4><span id='descrizione'>" . $row["descrizione"] . "</span></h4>";

        // Aggiungi un bottone per i dettagli, passando l'id della segnalazione
        echo "<button type='button' onclick='dettagliSegnalazione(" . $row["id"] . ")' class='defaultButton'>Dettagli..</button>";

        echo "</div>";
    }
} else {
    echo "Nessuna segnalazione trovata.";
}

// Chiudi la connessione
$stmt->close();
$conn->close();
?>
