<?php

require_once 'connessioneDB.php';

// Ottieni il nome dell'aula dal POST
$aula = $_POST['aula'];

// Prepara e esegui la query
$sql = $conn->prepare("SELECT id FROM luoghi WHERE nome = ?");
$sql->bind_param("s", $aula);
$sql->execute();
$sql->bind_result($id);
$sql->fetch();

// Verifica se è stato trovato un risultato
if ($id) {
    echo $id;
} else {
    echo "Nessun risultato trovato";
}

// Chiudi la connessione
$sql->close();
$conn->close();
?>