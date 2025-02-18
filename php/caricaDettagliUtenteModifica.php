<?php

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'conn_db_SK.php';


$id = isset($_SESSION['user_modificare_id']) ? $_SESSION['user_modificare_id'] : 'null';

if (!$id) {
    echo "Errore: ID utente non trovato.";
    exit;
}

$sql = "SELECT nome, email, tipo FROM utenti WHERE id = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    error_log("Prepare failed: " . $conn->error);
    echo "Errore nella preparazione della query.";
    exit;
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?>
    <div class='testa'>
        <h3><span id='tipoUtente'><?= htmlspecialchars($row["tipo"]) ?></span></h3>
        <img id='tipoUtenteImg' src='icone/profile_test_icon.png' class='profile'>
    </div>
    <p>Nome: <span id='nome'><?= htmlspecialchars($row["nome"]) ?></span></p>
    <p>E-mail: <span id='e-mail'><?= htmlspecialchars($row["email"]) ?></span></p>
    <?php
} else {
    echo "Nessun utente trovato.";
}

$stmt->close();

?>
