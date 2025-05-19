<?php

require_once 'conn_db_SK.php';

// Ottieni il nome dell'aula dal POST
$nome = $_POST['nome'];



// Prepara e esegui la query
$sql = $conn->prepare("SELECT id FROM luoghi WHERE nome = ?");
$sql->bind_param("s", $nome);
$sql->execute();
$sql->bind_result($id);
$sql->fetch();

// Verifica se è stato trovato un risultato
if ($id) {
    echo $id;
} else {
    echo null;
    
}

// Chiudi la connessione
$sql->close();
$conn->close();
?>
