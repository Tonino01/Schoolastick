<?php

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'conn_db_SK.php';


$id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null';

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
    
    <h3 class='testa'><span id='tipoUtente'><?= htmlspecialchars($row["tipo"]) ?></span></h3>
    
    <p>Nome: <br><span id='nome'><?= htmlspecialchars($row["nome"]) ?></span></p>
    <p>E-mail: <span id='e-mail'><?= htmlspecialchars($row["email"]) ?></span></p>

    <button type="button" onclick="logOut()" class="annulla">LOG OUT</button>
    <button type="button" onclick="segnalazioni()" class="annulla">INDIETRO</button>
    <?php
} else {
    echo "Nessun utente trovato.";
    echo "<button type='button' onclick='logOut()' class='annulla'>LOG OUT</button>";
    echo "<button type='button' onclick='segnalazioni()'' class='annulla'>INDIETRO</button>";
}

$stmt->close();

?>
