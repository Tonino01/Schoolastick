<?php

  require_once 'php/connessioneDB.php';

  // Verifica se i dati necessari sono stati inviati tramite POST
  if (isset($_POST['descrizione'], $_POST['id_utente_crea'], $_POST['luogo_id'])) {
      // Recupera i dati dal form
      $descrizione = $_POST['descrizione'];
      $data_creazione = date("Y-m-d H:i:s");
      $report = "";
      $stato = "Da fare";
      $id_utente_crea = $_POST['id_utente_crea'];
      $id_utente_lavora = NULL;
      $id_utente_completa = NULL;
      $luogo_id = $_POST['luogo_id'];
      
      // Prepara la query di inserimento
      $sql = "INSERT INTO segnalazioni (descrizione, data_creazione, report, stato, id_utente_crea, id_utente_lavora, id_utente_completa, luogo_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

      // Prepara lo statement
      if ($stmt = $conn->prepare($sql)) {
          // Associa i parametri
          $stmt->bind_param("sii", $descrizione, $id_utente_crea, $luogo_id);

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
