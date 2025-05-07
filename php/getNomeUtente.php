<?php
session_start();
echo isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'null';

?>
