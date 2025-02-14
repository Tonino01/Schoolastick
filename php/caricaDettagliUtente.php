<?php
session_start();

ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'conn_db_SK.php';

// Verifica che il metodo sia POST e che l'ID sia presente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']); // Converte in intero per sicurezza

    if ($id <= 0) {
        echo "ID utente non valido.";
        exit;
    }

    // Prepara la query in modo sicuro
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

    // Verifica se ci sono risultati
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Output HTML sicuro
        ?>
        <div class='testa'>
            <h3><span id='tipoUtente'><?= htmlspecialchars($row["tipo"]) ?></span></h3>
            <img id='tipoUtenteImg' src='icone/profile_test_icon.png' class='profile' onclick='mostraInfoAccount()'>
        </div>
        <p>Nome: <span id='nome'><?= htmlspecialchars($row["nome"]) ?></span></p>
        <p>E-mail: <span id='e-mail'><?= htmlspecialchars($row["email"]) ?></span></p>
        <?php
    } else {
        echo "Nessun utente trovato con ID = " . $id;
    }

    $stmt->close();
} else {
    echo "Richiesta non valida.";
}

$conn->close();
?>
