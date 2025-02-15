<?php
include 'conn_db_SK.php';

$id_segnalazione = $_POST['id_segnalazione'];
$stato_corrente = $_POST['stato_corrente'];

$stati = ["Nuova", "In corso", "Completa", "Archiviata"];
$indice_corrente = array_search($stato_corrente, $stati);

if ($indice_corrente !== false && $indice_corrente < count($stati) - 1) {
    $nuovo_stato = $stati[$indice_corrente + 1];
    $sql = "UPDATE segnalazioni SET stato = '$nuovo_stato' WHERE id = $id_segnalazione";
    if ($conn->query($sql) === TRUE) {
        echo "Stato aggiornato con successo a $nuovo_stato";
    } else {
        echo "Errore nell'aggiornamento dello stato: " . $conn->error;
    }
} else {
    echo "Stato non valido o già all'ultimo stato.";
}

$conn->close();
?>
