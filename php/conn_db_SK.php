<?php

    echo "<h1>PHP nei DataBase</h1>";
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "schoolastick_prova";

    //Creazione della connessione
    $conn = new mysqli ($servername, $username, $password, $dbname);

    //Si usa una stringa all'interno dell'if(viene trattato come un booleano, 
    //(se è piena true, o vuota false)
    if ($conn->connect_error){
        //Stampa come echo e termina
        die("Connessione fallita: " . $conn->connect_error);
    }
    
    echo "Connessione al database riuscita." . "<br>";

?>