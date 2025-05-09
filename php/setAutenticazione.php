<?php
include 'conn_db_SK.php';

session_start();
if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
}
$session_duration = 900;
if (time() - $_SESSION['start_time'] > $session_duration) {
    
    die("exit");
}


$id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null';
if (!$id) {
    echo "Errore: ID utente non trovato.";
    exit;
}



$autenticazione = isset($_POST['autenticazione']) ? $_POST['autenticazione'] : 'null';
if ($autenticazione === 'null') {
    echo "Errore: Autenticazione non trovata.";
    exit;
}





if($autenticazione == 1){

    $autenticazione = 0;

}elseif($autenticazione == 0){
    $autenticazione = 1;
}else{
    echo "Errore: Autenticazione.";
    exit;
}




$sql = "UPDATE utenti SET autenticazione = '$autenticazione' WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    echo "autenticazione a 2 fattori aggiornata con successo";
} else {
    echo "Errore nell'aggiornamento dello stato di autenticazione a 2 fattori: " . $conn->error;
}

$conn->close();
?>