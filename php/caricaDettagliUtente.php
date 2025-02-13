<?php

session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'conn_db_SK.php';

// Ottiene l'ID della segnalazione dalla richiesta POST
if (isset($_POST['id'])) {
    $id = $_POST['id']; // Prendi il parametro id dalla richiesta

    // Log the received ID
    error_log("Received ID: " . $id);

    // Prepara la query SQL
    $sql = "SELECT nome, email, tipo 
            FROM utenti
            WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        error_log("Prepare failed: " . $conn->error);
        echo "Errore nella preparazione della query.";
        exit;
    }
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verifica se ci sono risultati
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Echo dei dettagli in formato HTML
        echo "<div class='testa'>";
        echo "<h3><span id='tipoUtente'>" . htmlspecialchars($row["tipo"]) . "</span></h3>";
        echo "<img id='tipoUtenteImg' src='icone/profile_test_icon.png' class='profile' onclick='mostraInfoAccount()'>";
        echo "</div>";

        echo "<p>Nome<span id='nome'>" . htmlspecialchars($row["nome"]) . "</span></p>";
        echo "<p>E-mail<span id='e-mail'>" . htmlspecialchars($row["email"]) . "</span></p>";
    } else {
        error_log("No user found with ID: " . $id);
        echo "Nessuna utente trovato.";
    }

} else {
    echo "Nessun ID ricevuto";
}

// Chiude la connessione
$conn->close();
?>