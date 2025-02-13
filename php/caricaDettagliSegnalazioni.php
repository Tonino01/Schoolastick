<?php
require_once 'conn_db_SK.php';

// Ottiene l'ID della segnalazione dalla richiesta GET

if (isset($_POST['id'])) {

    $id = $_POST['id']; // Prendi il parametro id dalla query string
    echo "ID ricevuto: " . htmlspecialchars($id);
} else {
    echo "Nessun ID ricevuto";
}



// Prepara la query SQL
$sql = "SELECT s.*, u.nome AS nome_utente, l.nome AS nome_luogo, p.nome AS nome_piano, se.nome AS nome_sede FROM segnalazioni s
        LEFT JOIN utenti u ON s.id_utente_crea = u.id
        LEFT JOIN luoghi l ON s.luogo = l.id
        LEFT JOIN piani p ON l.piano = p.id
        LEFT JOIN sedi se ON p.sede = se.id
        WHERE s.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se ci sono risultati
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    echo "<div class='barraStato'>";
    echo "<h4><span id='stato'>" . $row["stato"] . "</span></h4>";
    echo "</div>";

    echo "<p>DESCRIZIONE: <span id='descrizione'>" . $row["descrizione"] . "</span></p>";
    echo "<p>DATA CREAZIONE: <span id='data_creazione'>" . $row["data_creazione"] . "</span></p>";
    echo "<p>CREATA DA: <span id='id_utente_crea'>" . $row["nome_utente"] . "</span></p>";
    echo "<p>CATEGORIA: <span id='categoria'>" . $row["categoria"] . "</span></p>";
    echo "<p>SEDE: <span id='sede'>" . $row["nome_sede"] . "</span></p>";
    echo "<p>PIANO: <span id='piano'>" . $row["nome_piano"] . "</span></p>";
    echo "<p>LUOGO: <span id='luogo'>" . $row["nome_luogo"] . "</span></p>";

    echo "<div class='pulsanti'>";
    echo "<button type='button' onclick='segnalazioni()'>INDIETRO</button>";
    echo "<div id='mButton'></div>";
    echo "</div>";
} else {
    echo "Nessuna segnalazione trovata.";
}

// Chiude la connessione
$conn->close();
?>
