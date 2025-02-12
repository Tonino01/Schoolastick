<?php
session_start(); // Avvia la sessione

require_once("conn_db_SK.php"); // Collegamento al database

// Controlla se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    if (!$email || !$password) {
        die("Errore: Tutti i campi sono obbligatori. <br><a href='login.html'>Torna indietro</a>");
    }

    // Cerca l'utente nel database
    $sql = "SELECT id, nome, password, tipo FROM utenti WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $nome, $passwordHash, $tipo);
        $stmt->fetch();

        if (password_verify($password, $passwordHash)) {
            // Salva i dati nella sessione
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $nome;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_tipo'] = $tipo;

            // Reindirizza alla pagina specifica in base al tipo di utente
            switch ($tipo) {
                case 'Studente':
                    header("Location: ../indexStudente.html");
                    break;
                case 'Docente':
                    header("Location: ../indexDocente.html");
                    break;
                case 'Tecnico':
                    header("Location: ../indexTecnico.html");
                    break;
                case 'Amministratore':
                    header("Location: ../indexAmministratore.html");
                    break;
                default:
                    echo "Errore: Tipo di utente non valido.";
                    exit;
            }
        } else {
            echo "Errore: Password errata. <br><a href='accedi.html'>Torna indietro</a>";
        }
    } else {
        echo "Errore: Utente non trovato. <br><a href='accedi.html'>Torna indietro</a>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Accesso non autorizzato!!";
}
?>
