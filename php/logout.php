<?php
session_start();
session_destroy();
header("Location: ../accedi.html");
exit;
?>