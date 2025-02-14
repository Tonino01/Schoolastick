<?php
include 'conn_db_SK.php';

$id_segnalazione = $_POST['id_segnalazione'];
$report = $_POST['report'];

if (!empty($report)) {
    $sql = "UPDATE segnalazioni SET stato = 'Completa', report = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $report, $id_segnalazione);
    if ($stmt->execute()) {
        echo "Report inviato e stato aggiornato a Completa";
    } else {
        echo "Errore nell'invio del report: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Il report non può essere vuoto.";
}

$conn->close();
?>
