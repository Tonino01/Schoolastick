<?php
require_once("conn_db_SK.php");

$categoria = isset($_GET['categoria']) ? $_GET['categoria'] : '';

// Costruire la query in base al filtro
$sql = "SELECT * FROM segnalazioni";
if (!empty($categoria)) {
    $sql .= " WHERE categoria = ?";
}

$stmt = $conn->prepare($sql);

// Se è stata selezionata una categoria, bind dei parametri
if (!empty($categoria)) {
    $stmt->bind_param("s", $categoria);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='segnalazione'>";
        echo "<div class='barraSegnalazione'>";
        echo "<h4><span id='completamento'>" . $row["stato"] . "</span></h4>";
        echo "</div>";
        echo "<h4><span id='descrizione'>" . $row["descrizione"] . "</span></h4>";
        echo "<button type='button' onclick='dettagliSegnalazione()' class='defaultButton'>Dettagli..</button>";
        echo "</div>";
    }
} else {
    echo "Nessuna segnalazione trovata.";
}

$stmt->close();
$conn->close();
?>
