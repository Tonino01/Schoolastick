<?php

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);


require_once 'conn_db_SK.php';

// Ottiene l'ID della segnalazione dalla richiesta POST
if (isset($_POST['id'])) {
    $id = $_POST['id']; // Prendi il parametro id dalla richiesta

    // Prepara la query SQL
    $sql = "SELECT s.*, u.nome AS nome_utente, l.nome AS nome_luogo, p.nome AS nome_piano, se.nome AS nome_sede FROM segnalazioni s
            LEFT JOIN utenti u ON s.id_utente_crea = u.id
            LEFT JOIN luoghi l ON s.luogo_id = l.id
            LEFT JOIN piani p ON l.piano_id = p.id
            LEFT JOIN sedi se ON p.sede_id = se.id
            WHERE s.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se ci sono risultati
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Echo dei dettagli in formato HTML
        echo "<div class='barraStato'>";
        echo "<h4><span id='stato'>" . htmlspecialchars($row["stato"]) . "</span></h4>";
        echo "</div>";

        echo "<p>DESCRIZIONE: <span id='descrizione'>" . htmlspecialchars($row["descrizione"]) . "</span></p>";
        echo "<p>DATA CREAZIONE: <span id='data_creazione'>" . htmlspecialchars($row["data_creazione"]) . "</span></p>";
        echo "<p>CREATA DA: <span id='id_utente_crea'>" . htmlspecialchars($row["nome_utente"]) . "</span></p>";
        echo "<p>CATEGORIA: <span id='categoria'>" . htmlspecialchars($row["categoria"]) . "</span></p>";
        echo "<p>SEDE: <span id='sede'>" . htmlspecialchars($row["nome_sede"]) . "</span></p>";
        echo "<p>PIANO: <span id='piano'>" . htmlspecialchars($row["nome_piano"]) . "</span></p>";
        echo "<p>LUOGO: <span id='luogo'>" . htmlspecialchars($row["nome_luogo"]) . "</span></p>";

        echo "<div class='pulsanti'>";
        echo "<button type='button' onclick='segnalazioni()'>INDIETRO</button>";

        if($row["stato" == "Nuova"]){

          echo "<button type='button'>CONTRASSEGNA COME IN CORSO</button>";

        }elseif($row["stato" == "In corso"]){

          echo "<button type='button'>SCRIVI REPORT</button>";

        }elseif ($row["stato" == "Completa"]) {
          // code...
        }

        echo "<div id='mButton'></div>";



        echo "</div>"
    } else {
        echo "Nessuna segnalazione trovata.";
    }

} else {
    echo "Nessun ID ricevuto";
}

// Chiude la connessione
$conn->close();
?>
