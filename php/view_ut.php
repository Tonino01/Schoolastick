<?php

session_start();
require_once("conn_db_SK.php");

$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

$sql = "SELECT * FROM utenti";
if (!empty($search)) {
    $sql .= " WHERE nome LIKE '%$search%' OR email LIKE '%$search%'";
}

$result = $conn->query($sql);
$utenti_html = "";

while ($row = $result->fetch_assoc()) {
    $initial = strtoupper(substr($row['nome'], 0, 1));
    $tipo = htmlspecialchars($row['tipo']);
    $nome = htmlspecialchars($row['nome']);
    $id = $row['id'];

    

    
    echo "    <div class='utente'>
        <div class='circle $tipo'>$initial</div>
            <div class='name'>$nome        </div>
                <button class='button' onclick='mostraModificaUtente(".$id.")'>MODIFICA</button>
    </div>";
}

echo $utenti_html;

$conn->close();
?>
