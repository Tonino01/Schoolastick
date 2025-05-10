<?php

require_once("conn_db_SK.php");

session_start();

// Recupero dati dal form
$nome = $_POST['nome'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm-password'];


$_SESSION["Rnome"] = $nome; 
$_SESSION["Remail"] = $email;
$_SESSION["Rpassword"] = $password;



if ($password !== $confirm_password) {
    die("Errore: Le password non corrispondono. <br><a href='../registra.html'>Torna indietro</a>");
}

// Controllo del dominio dell'email
$dominioConsentito = "@iisvittorioveneto.it";
if (!str_ends_with($email, $dominioConsentito)) {
    die("Errore: Devi usare un'email con dominio " . $dominioConsentito . "<br><a href='../registra.html'>Torna indietro</a>");
}


// Verifica se l'email è già registrata
$sqlCheck = "SELECT id FROM utenti WHERE email = ?";
$checkStmt = $conn->prepare($sqlCheck);
$checkStmt->bind_param("s", $email);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    die("Errore: Questa email è già registrata. <br><a href='../registra.html'>Torna indietro</a>");



}


$scadenza = date("Y-m-d H:i:s", strtotime("+1 hour"));



$subject = "Conferma Registrazione - Schoolastick";
$message = "

CONFERMA REGISTRAZIONE CLICCANDO IL LINK SEGUENTE:

https://schoolastick.ittvive.it/php/registra.php


";
mail($email, $subject, $message, "From: no-reply@schoolastick.it");







?>

<!DOCTYPE html>
<html lang="it">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="Css/accedi.css">
    <link rel="icon" type="image/x-icon" href="icone/logo_default.png" >
    <head>
        <meta charset="UTF-8">
                        
        <title>CONFERMA E-MAIL</title>
    </head>
    <body>
        <h1>L'e-mail è stata inviata con successo</h1>
        <br>
        <p>puoi chiudere questa pagina o tornale al login</p>
                        
        <a href="../accedi.html">Torna al login</a>
    </body>
</html>