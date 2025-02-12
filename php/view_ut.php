<?php
	require_once ("conn_db_SK.php");

    // R di CRUD: read
	$sql = "SELECT * FROM utenti";
	$result = $conn-> query($sql);
	
	echo ("<br>");
	if ($result -> num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			echo "ID: " .$row["id"] . " - Nome: " . $row["nome"] . " - Email: " . $row["email"] . " - Password: " . $row["password"] . "<br>";
		}
	} else {
		echo "Nessuno utente trovato.";
	}

    //fine: chiusura dell'oggetto
	$conn->close();

    ?>