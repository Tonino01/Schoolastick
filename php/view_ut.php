<?php


require_once("conn_db_SK.php");

session_start();
if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
}

$session_duration = 900;
if (time() - $_SESSION['start_time'] > $session_duration) {
    
    die("exit");
}



$sql = "SELECT * FROM utenti";


$result = $conn->query($sql);
$utenti_html = "";

while ($row = $result->fetch_assoc()) {
    $initial = strtoupper(substr($row['nome'], 0, 1));
    $nome = htmlspecialchars($row['nome']);
    $id = $row['id'];

    
    ?>

    <div class='utente'>
        <div id ='<?= htmlspecialchars($row["tipo"]) ?>' class='circle <?= htmlspecialchars($row["tipo"]) ?>'>   <?= htmlspecialchars($initial) ?>    </div>
            <div class='name'><?= htmlspecialchars($nome) ?> </div>
                <button class='button' onclick='mostraModificaUtente(<?= htmlspecialchars($id) ?>)'>MODIFICA</button>
    </div>


    <?php
    
    echo "    ";
}

echo $utenti_html;

$conn->close();
?>
