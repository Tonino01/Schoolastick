<?php

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'conn_db_SK.php';

// Verifica se l'ID è stato ricevuto nella richiesta POST
if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo 'Nessun ID ricevuto';
    exit;
}

$id = $_POST['id'];

// Prepara la query SQL per recuperare i dettagli della segnalazione
$sql = "SELECT s.*, u.nome AS nome_utente, l.nome AS nome_luogo, p.nome AS nome_piano, se.nome AS nome_sede
        FROM segnalazioni s
        LEFT JOIN utenti u ON s.id_utente_crea = u.id
        LEFT JOIN luoghi l ON s.luogo_id = l.id
        LEFT JOIN piani p ON l.piano_id = p.id
        LEFT JOIN sedi se ON p.sede_id = se.id
        WHERE s.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    echo "<div class='barraStato'>";
    echo "<h4><span id='stato'>" . htmlspecialchars($row["stato"]) . "</span></h4>";
    echo "</div>";

    echo "<p>DESCRIZIONE: <span id='descrizione'>" . htmlspecialchars($row["descrizione"]) . "</span></p>";

    if ($row["stato"] == 'Completa') {
        echo "<p>REPORT: <span id='report'>" . htmlspecialchars($row["report"]) . "</span></p>";
    }

    echo "<p>DATA CREAZIONE: <span id='data_creazione'>" . htmlspecialchars($row["data_creazione"]) . "</span></p>";
    echo "<p>CREATA DA: <span id='id_utente_crea'>" . htmlspecialchars($row["nome_utente"]) . "</span></p>";
    echo "<p>CATEGORIA: <span id='categoria'>" . htmlspecialchars($row["categoria"]) . "</span></p>";
    echo "<p>SEDE: <span id='sede'>" . htmlspecialchars($row["nome_sede"]) . "</span></p>";
    echo "<p>PIANO: <span id='piano'>" . htmlspecialchars($row["nome_piano"]) . "</span></p>";
    echo "<p>LUOGO: <span id='luogo'>" . htmlspecialchars($row["nome_luogo"]) . "</span></p>";

    echo "<div class='pulsanti'>";
    echo "<button type='button' onclick='segnalazioni()' class='annulla'>INDIETRO</button>";

    // Verifica l'ID utente nella sessione
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null';
    $sql_user = "SELECT tipo FROM utenti WHERE id = ?";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("i", $user_id);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();
    $user = $result_user->fetch_assoc();
    $tipo_utente = $user['tipo'];

    if ($tipo_utente == 'Tecnico' || $tipo_utente == 'Amministratore') {
        if ($row["stato"] == 'Nuova') {
            echo "<button id='buttonModificaSegnalazione' onclick='modificaSegnalazione($id, \"Nuova\")' type='button'>CONTRASSEGNA COME IN CORSO</button>";
        } elseif ($row['stato'] == "In corso") {
            echo "<button id='buttonModificaSegnalazione' onclick='modificaSegnalazione($id, \"In corso\")' type='button'>SCRIVI REPORT</button>";
        } elseif ($row['stato'] == "Completa") {
            echo "<button id='buttonModificaSegnalazione' onclick='modificaSegnalazione($id, \"Completa\")' type='button'>ARCHIVIA</button>";
        }
    }

    echo "</div>";
} else {
    echo 'Nessuna segnalazione trovata.';
}

$conn->close();
?>
