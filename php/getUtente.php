<?php
session_start();
echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'null';

?>
