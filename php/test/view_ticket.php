<?php

require_once("conn_db_SK.php"); // Collegamento al database

// Assumiamo che l'utente sia autenticato
if (!isset($_SESSION['user_id'])) {
    die("Accesso non autorizzato.");
}

$user_id = $_SESSION['user_id'];

// Query per ottenere le segnalazioni dell'utente
$sql = "SELECT s.id, s.descrizione, s.data_creazione, l.nome AS luogo
        FROM segnalazioni s
        JOIN luoghi l ON s.luogo_id = l.id
        WHERE s.id_utente_crea = :user_id
        ORDER BY s.data_creazione DESC";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();

$segnalazioni = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Le mie segnalazioni</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Le mie segnalazioni</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Descrizione</th>
        <th>Data Creazione</th>
        <th>Luogo</th>
    </tr>
    <?php foreach ($segnalazioni as $segnalazione): ?>
        <tr>
            <td><?= htmlspecialchars($segnalazione['id']) ?></td>
            <td><?= htmlspecialchars($segnalazione['descrizione']) ?></td>
            <td><?= htmlspecialchars($segnalazione['data_creazione']) ?></td>
            <td><?= htmlspecialchars($segnalazione['luogo']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
