<?php
require_once 'conn_db_SK.php';

// Ottieni il parametro di ricerca dal POST
$descrizione = $_POST['descrizione'];
$stato = $_POST['stato'];
$categoria = $_POST['categoria'];
$sede = $_POST['sede'];

// Costruisci la query in base ai parametri di ricerca
$sql = "SELECT s.id, s.descrizione, s.stato, s.categoria FROM segnalazioni s 
        JOIN utenti u ON s.id_utente_crea = u.id
        JOIN luoghi l ON s.luogo_id = l.id
        JOIN piani p ON l.piano_id = p.id
        JOIN sedi se ON p.sede_id = se.id
        WHERE s.descrizione LIKE ? OR l.nome LIKE ? OR p.nome LIKE ?
        AND se.nome LIKE ? AND s.stato LIKE ? AND s.categoria LIKE ? AND s.stato != 'Archiviata'
        ";

$stmt = $conn->prepare($sql);

// Aggiungi i parametri di ricerca con i caratteri jolly per la ricerca parziale
$termineCercato = "%" . $descrizione . "%";
$statoCercato = ($stato == "Qualunque") ? "%" : $stato;
$categoriaCercata = ($categoria == "Qualunque") ? "%" : $categoria;
$sedeCercata = ($sede == "Tutte") ? "%" : $sede;
$stmt->bind_param("ssssss", $termineCercato, $termineCercato, $termineCercato, $sedeCercata, $statoCercato, $categoriaCercata);

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
