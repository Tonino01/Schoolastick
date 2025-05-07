<?php


include 'conn_db_SK.php';

session_start();
if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
}

$session_duration = 900;
if (time() - $_SESSION['start_time'] > $session_duration) {
    
    die("exit");
}

$n_sede = $_POST['sede'];

    $sql = "INSERT INTO sedi (nome) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $n_sede);
    if ($stmt->execute()) {
        echo "Sede creata con successo!";
    }else {
        echo "Errore nella creazione di una sede: " . $stmt->error;
    }
    $stmt->close();


    $conn->close();


?>