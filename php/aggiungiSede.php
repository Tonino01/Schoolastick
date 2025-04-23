<?php


include 'conn_db_SK.php';

session_start();
if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
}

$session_duration = 300;
if (time() - $_SESSION['start_time'] > $session_duration) {
    
    die("exit");
}


if{isset($_POST['n_sede'])) {
    $n_sede = $_POST['n_sede'];
} else {
    die("Nome sede non fornito.");
}

$sql = "INSERT INTO sedi (nome) VALUES (?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $n_sede);
if ($stmt->execute()) {
    echo "Report inviato e stato aggiornato a Completa";
} else {
    echo "Errore nell'invio del report: " . $stmt->error;
}
$stmt->close();


$conn->close();
?>
<div class="creaSegnalazione">


<div class="selezionaPiano">

  <h4><span id = "titoloNuova">INSERISCI SEDE</span></h4>

  <form action="aggiungiSede.php" method = "POST">

    <input type="text" id="n_sede" name="n_sede" placeholder="Nome sede" required>
    <button type="submit" class="annulla">Crea</button>
    <button type="button" class="annulla" onclick="segnalazioni()">Annulla</button>

</form>
</div>


</div>
