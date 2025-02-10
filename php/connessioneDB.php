<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "schoolastck";

//connessione

$connessione = new mysqli($servername, $username, $password, $dbname);



if($connessione -> connect_error){

    die("connessione non eseguita" . $connessione->connect_error);

    echo "connessione non riuscita";

}else{

    //echo "connessione riuscita";

}

?>
