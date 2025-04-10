<?php

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'conn_db_SK.php';


$id = $_GET['id'];





$sql = "SELECT nome, email, tipo FROM utenti WHERE id = ?";
$stmt = $conn->prepare($sql);


$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();

    ?>
    <div class='testa'>
        <h3><span id='tipoUtente'><?= htmlspecialchars($row["tipo"]) ?></span></h3>
        <img id='tipoUtenteImg' src='icone/profile_test_icon.png' class='profile'>
    </div>
    <p>Nome: <span id='nome'><?= htmlspecialchars($row["nome"]) ?></span></p>
    <p>E-mail: <span id='e-mail'><?= htmlspecialchars($row["email"]) ?></span></p>

    <label for="permesso"><h5>SELEZIONA PERMESSO:</h5></label>
    <select id="permesso" name="ruolo" method="post">
        <option value = "Amministratore">Amministratore</option>
        <option value = "Tecnico">Tecnico</option>
        <option value = "Docente">Docente</option>
        <option value = "Studente">Studente</option>
    </select>

    <button type="button" id = "salva" class = "button" onclick="salvaTipoUtente(<?= $id ?>)" >SALVA PERMESSI</button>
  
    <button type="button" id = "elimina" class = "button" onclick="eliminaUtente(<?= $id ?>)" >ELIMINA UTENTE</button>

    <button type="button" id = "indietro" class = "button" onclick="mostraUtenti()" >INDIETRO</button>
    <?php
} else {
    echo "Nessun utente trovato.";
    echo "<button type='button' id = 'indietro' class = 'button' onclick='mostraUtenti()' >INDIETRO</button>";
}

$stmt->close();

?>
