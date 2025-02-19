<?php
session_start();

include 'conn_db_SK.php';

$id_segnalazione = $_POST['id_segnalazione'];
$report = $_POST['report'];
$id_utente = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null';;


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



if (!empty($id_utente)) {
    $sql = "UPDATE segnalazioni SET	id_utente_completa = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_utente, $id_segnalazione);
    if ($stmt->execute()) {
        echo "utente impostato correttamente";
    } else {
        echo "Errore nell'inserimento utente: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Utente inesistente";
}

$conn->close();
?>
