<?php
require_once("conn_db_SK.php");

// Recupera il valore di ricerca se presente
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Query SQL con filtro di ricerca
$sql = "SELECT * FROM utenti";
if (!empty($search)) {
    $sql .= " WHERE nome LIKE '%$search%' OR email LIKE '%$search%'";
}

$result = $conn->query($sql);
?>

<!-- Form di ricerca -->
<form method="GET" action="">
    <input type="text" name="search" placeholder="Cerca utente..." value="<?php echo htmlspecialchars($search); ?>">
    <input type="submit" value="Cerca">
</form>

<?php
// Visualizzazione utenti
echo "<br>";
while ($row = $result->fetch_assoc()) {
    echo "ID: " . $row["id"] . " - Nome: " . $row["nome"] . " - Email: " . $row["email"] . " - Tipo: " . $row["tipo"];

    // Form per eliminare l'utente
    echo " <form method='POST' action='elimina_ut.php' style='display:inline;'>
            <input type='hidden' name='id' value='" . $row["id"] . "'>
            <input type='submit' value='Elimina'>
          </form>";

    // Form per modificare il tipo di utente
    echo " <form method='POST' action='modifica_tipo.php' style='display:inline; margin-left: 10px;'>
            <input type='hidden' name='id' value='" . $row["id"] . "'>
            <select name='tipo'>
                <option value='Studente' " . ($row["tipo"] == "Studente" ? "selected" : "") . ">Studente</option>
                <option value='Tecnico' " . ($row["tipo"] == "Tecnico" ? "selected" : "") . ">Tecnico</option>
                <option value='Docente' " . ($row["tipo"] == "Docente" ? "selected" : "") . ">Docente</option>
                <option value='Amministratore' " . ($row["tipo"] == "Amministratore" ? "selected" : "") . ">Amministratore</option>
            </select>
            <input type='submit' value='Modifica'>
          </form>";

    echo "<br>&nbsp;";
}

// Chiusura connessione
$conn->close();
?>
