<?php



ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'conn_db_SK.php';

session_start();


$_SESSION["unverified_email"]=$_POST["email"];

$email = $_POST["email"];

$_SESSION["unverified_password"]=$_POST["password"];





$stmt = $conn->prepare("SELECT id, autenticazione FROM utenti WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($user_id, $autenticazione);
    $stmt->fetch();

    // Salva l'id nella sessione

    if($autenticazione == 0) {
        
        header("Location: ../php/accedi.php?autenticazione=$autenticazione");


        exit();
    }
    
    $_SESSION['unverified_user_id'] = $user_id;

    
    $codice = mt_rand(10000, 99999);
    $scadenza = date("Y-m-d H:i:s", strtotime("+1 hour"));

    // Salva il codice e la scadenza nel database
    $stmt = $conn->prepare("INSERT INTO autenticazione_utente (codice, scadenza, unverified_user_id) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $codice, $scadenza, $user_id);
    $stmt->execute();

    $subject = "Autenticazione Utente di Schoolastick";
    $message = "Inserisci il codice qui sotto nella pagina di autenticazione:\n$codice\n";
    mail($email, $subject, $message, "From: no-reply@schoolastick.it");

    header("Location: ../verificaUtente.html");



    $stmt->close();
    
}else {
    ?>
                <!DOCTYPE html>
                    <html lang="it">
                    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
                    <link rel="stylesheet" href="../Css/accedi.css">
                    <link rel="icon" type="image/x-icon" href="../icone/logo_default.png" >
                    <head>
                        <meta charset="UTF-8">
                        
                        <title>Errore</title>
                    </head>
                    <body>
                        <h1>UTENTE INESISTENTE</h1>
                        <br>
                        
                        <div class="signup-link">Riprova ad accedere <a href="../accedi.html">Registarti</a></div>
                    </body>
                    </html>
                <?php
    exit();
}



?>