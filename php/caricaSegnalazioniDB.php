<?php


require_once 'conn_db_SK.php';

session_start();
if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
}

$session_duration = 900;
if (time() - $_SESSION['start_time'] > $session_duration) {
    
    die("exit");
}


// Esegui la query per ottenere le segnalazioni
$sql = "SELECT s.id AS id, s.stato AS stato, s.descrizione AS descrizione, S.nome AS sede, p.nome AS piano, l.nome AS luogo
        FROM segnalazioni s JOIN luoghi l
        ON s.luogo_id = l.id JOIN piani p 
        ON l.piano_id = p.id JOIN sedi S 
        ON p.sede_id = S.id 
        WHERE s.stato != 'Archiviata'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {

    // Ciclo su ogni segnalazione per generare l'HTML
    while($row = $result->fetch_assoc()) {

        // Stampa l'HTML con i dati della segnalazione
        echo "<div class='segnalazione'>";

        echo "<div id='" . $row["stato"] ."'  class='barraSegnalazione'>";
        echo "<h4><span id = 'idSegnalazione'></span><span id='completamento'>" . $row["stato"] . "</span></h4>";
        echo "</div>";

        echo "<h4>Descrizione:<br> <span id='descrizione'>" . $row["descrizione"] . "</span></h4>";

        echo "<h4>Posizione:<br><span id='posizione'>" . $row["sede"]." - ".  $row["piano"] ." - ".$row["luogo"]. "</span></h4>";

        

        // Aggiungi un bottone per i dettagli, passando l'id della segnalazione
        echo "<button type='button' onclick='dettagliSegnalazione(" . $row["id"] . ")' class='defaultButton'>Dettagli..</button>";

        echo "</div>";
    }
} else {
    echo "Nessuna segnalazione trovata.";
}

// Chiudi la connessione
$conn->close();
?>
