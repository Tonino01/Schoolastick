<?php
die("cane morto");
session_start();



session_unset();
session_destroy();


header("Location: ../accedi.html");
exit;
?>