<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "schoolastick_prova";

//connessione

$conn = new mysqli($servername, $username, $password, $dbname);



if($conn -> connect_error){

    die("connessione non eseguita" . $conn->connect_error);

    echo "connessione non riuscita";

}else{

    //echo "connessione riuscita";

}

?>
