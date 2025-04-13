<?php
session_start();
echo isset($_SESSION['user_tipo']) ? $_SESSION['user_tipo'] : 'null';

?>
