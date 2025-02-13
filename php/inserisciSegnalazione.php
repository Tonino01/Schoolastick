<?php

  session_start();

  require_once 'conn_db_SK.php';

  // Verifica se i dati necessari sono stati inviati tramite POST
  if (isset($_POST['descrizione'], $_POST['id_utente_crea'], $_POST['luogo_id'])) {
      // Recupera i dati dal form
      $descrizione = $_POST['descrizione'];
      $data_creazione = date("Y-m-d H:i:s");
      $id_utente_crea = $_POST['id_utente_crea'];
      $luogo_id = $_POST['luogo_id'];

      // Prepara la query di inserimento
      $sql = "INSERT INTO segnalazioni (descrizione, data_creazione, id_utente_crea, luogo_id) VALUES (?, ?, ?, ?)";

      // Prepara lo statement
      if ($stmt = $conn->prepare($sql)) {
          // Associa i parametri
          $stmt->bind_param("sii", $descrizione, $data_creazione, $id_utente_crea, $luogo_id);

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
