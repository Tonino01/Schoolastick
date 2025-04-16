<?php


    $servername = "srv1342.hstgr.io";
    $username = "u482179263_schoolastick";
    $password = "&xP8boC7r1";
    $dbname = "u482179263_schoolastick";

    //Creazione della connessione
    $conn = new mysqli ($servername, $username, $password, $dbname);

    //Si usa una stringa all'interno dell'if(viene trattato come un booleano,
    //(se è piena true, o vuota false)
    if ($conn->connect_error){
        //Stampa come echo e termina
        die("Connessione fallita: " . $conn->connect_error);
    }

    

?>
