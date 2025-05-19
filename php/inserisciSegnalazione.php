<?php



  session_start();
if (!isset($_SESSION['start_time'])) {
    $_SESSION['start_time'] = time();
}

$session_duration = 900;
if (time() - $_SESSION['start_time'] > $session_duration) {
    
    die("exit");
}

  require_once 'conn_db_SK.php';

  // Verifica se i dati necessari sono stati inviati tramite POST
  if (isset($_POST['descrizione'], $_POST['id_utente_crea'], $_POST['luogo_id'], $_POST['categoria'])) {


      // Recupera i dati dal form
      $descrizione = $_POST['descrizione'];
      $data_creazione = date("Y-m-d H:i:s");
      $id_utente_crea = $_POST['id_utente_crea'];
      $luogo_id = $_POST['luogo_id'];
      $categoria = $_POST['categoria'];

      

      // Prepara la query di inserimento
      $sql = "INSERT INTO segnalazioni (descrizione, data_creazione, id_utente_crea, luogo_id, categoria) VALUES (?, ?, ?, ?, ?)";

      // Prepara lo statement
      if ($stmt = $conn->prepare($sql)) {
          // Associa i parametri
          $stmt->bind_param("ssiis", $descrizione, $data_creazione, $id_utente_crea, $luogo_id, $categoria);

          // Esegui lo statement
          if ($stmt->execute()) {

              echo "Segnalazione inserita con successo.";

              exit;

          } else {
              echo "Errore durante l'inserimento della segnalazione: " . $stmt->error;
          }

          // Chiudi lo statement
          $stmt->close();
      } else {
          echo "Errore nella preparazione dello statement: " . $conn->error;
      }
  } else {
      echo "Dati mancanti. Assicurati di aver compilato tutti i campi richiesti.";
  }

?>
