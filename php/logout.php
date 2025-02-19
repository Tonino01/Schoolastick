<?php
session_start();

session_uset();
session_destroy();


header("Location: ../accedi.html");
exit;
?>