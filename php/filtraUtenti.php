<?php
require_once 'conn_db_SK.php';

session_start();
if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
}

$session_duration = 900;
if (time() - $_SESSION['start_time'] > $session_duration) {
    
    die("exit");
}

// Ottieni il parametro di ricerca dal POST
$nome = $_POST['nome'];
$tipo = $_POST['tipo'];




$termineCercato = ($nome == "") ? "%" : "%" . $nome . "%";
$tipoCercato = ($tipo == "Tutti") ? "%" : $tipo;





// Costruisci la query in base ai parametri di ricerca
$sql = "SELECT * FROM utenti WHERE tipo LIKE '$tipoCercato' AND (nome LIKE '$termineCercato' OR email LIKE '$termineCercato')";

$result = $conn->query($sql);


if ($result->num_rows > 0) {

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
        
    }
} else {
    "Nessun utente trovato";
}



$conn->close();
?>
