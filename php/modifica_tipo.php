<?php
require_once("conn_db_SK.php");

session_start();
if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
}

$session_duration = 300;
if (time() - $_SESSION['start_time'] > $session_duration) {
    
    die("exit");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST["id"]);
    $tipo = $conn->real_escape_string($_POST["tipo"]);

    // Query per aggiornare il tipo dell'utente
    $sql = "UPDATE utenti SET tipo = '$tipo' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Tipo utente aggiornato con successo!";
    } else {
        echo "Errore durante l'aggiornamento: " . $conn->error;
    }

    $conn->close();

    // Torna alla pagina principale
    header("Location: view_ut.php");
    exit();
}
?>
