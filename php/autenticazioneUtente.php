<?php



ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'conn_db_SK.php';

session_start();
if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
}

$session_duration = 900;
if (time() - $_SESSION['start_time'] > $session_duration) {
    
    die("exit");
}

$_SESSION["unverified_email"]=$_POST["email"];

$_SESSION["unverified_password"]=$_POST["password"];



$stmt = $conn->prepare("SELECT id FROM utenti WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
 $stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($user_id);
    $stmt->fetch();

    // Salva l'id nella sessione
    $user_id = $_SESSION['unverified_user_id'];

}


$codice = mt_rand(10000, 99999);
$scadenza = date("Y-m-d H:i:s", strtotime("+1 hour"));

// Salva il codice e la scadenza nel database
$stmt = $conn->prepare("INSERT INTO recupero_password (user_id, codice, scadenza) VALUES (?, ?, ?)");
$stmt->bind_param("iss", $user_id, $codice, $scadenza);
$stmt->execute();

$subject = "Autenticazione Utente di Schoolastick";
$message = "Inserisci il codice qui sotto nella pagina di autenticazione:\n$codice\n";
mail($email, $subject, $message, "From: no-reply@schoolastick.it");





$stmt->close();


?>