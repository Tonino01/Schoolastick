<?php

session_start();
require_once("conn_db_SK.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_SESSION['user_modificare_id'];
    $tipo = $_POST["tipo"];

    // Query per aggiornare il tipo dell'utente
    $sql = "UPDATE utenti SET tipo = '$tipo' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Tipo utente aggiornato con successo!";
    } else {
        echo "Errore durante l'aggiornamento: " . $conn->error;
    }

    $conn->close();

    // Torna alla pagina principale
    header("Location: ../indexAmministratore.html");
    exit();
}
?>
