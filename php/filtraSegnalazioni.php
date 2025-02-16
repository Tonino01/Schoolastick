<?php
require_once 'conn_db_SK.php';

// Ottieni il parametro di ricerca dal POST
$descrizione = $_POST['descrizione'];
$stato = $_POST['stato'];
$categoria = $_POST['categoria'];

// Costruisci la query in base ai parametri di ricerca
$sql = "SELECT * FROM segnalazioni WHERE descrizione LIKE ? AND stato LIKE ? AND categoria LIKE ? AND stato != 'Archiviata'";
$stmt = $conn->prepare($sql);

// Aggiungi i parametri di ricerca con i caratteri jolly per la ricerca parziale
$searchTerm = "%" . $descrizione . "%";
$searchState = ($stato == "Qualunque") ? "%" : $stato;
$searchCategory = ($categoria == "Qualunque") ? "%" : $categoria;
$stmt->bind_param("sss", $searchTerm, $searchState, $searchCategory);

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

        echo "<h4>Descrizione:<br> <span id='descrizione'>" . $row["descrizione"] . "</span></h4>";
        echo "<h4>Categoria:<br><span id='categoria'>" . $row["categoria"] . "</span></h4>";

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
