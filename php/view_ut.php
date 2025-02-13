<?php
	require_once ("conn_db_SK.php");

    // R di CRUD: read
	$sql = "SELECT * FROM utenti";
	$result = $conn-> query($sql);
	
	echo ("<br>");
	while ($row = $result->fetch_assoc()) {
		// Mostra le informazioni dell'utente sulla stessa riga
		echo "ID: " . $row["id"] . " - Nome: " . $row["nome"] . " - Email: " . $row["email"] . " - Tipo: " . $row["tipo"];
	
		// Aggiungi il form con il bottone "Elimina" sulla stessa riga
		echo " <form method='POST' action='elimina_ut.php' style='display:inline;'>
				<input type='hidden' name='id' value='" . $row["id"] . "'>
				<input type='submit' value='Elimina'>
			  </form>";
		echo "<br>";
	
		// Puoi anche aggiungere un po' di spazio tra il bottone e le informazioni
		echo "&nbsp;"; 
	}
	

    //fine: chiusura dell'oggetto
	$conn->close();

?>