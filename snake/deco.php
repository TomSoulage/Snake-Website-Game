<?php
session_start();
session_destroy();
header('location: PageAcceuilJeu.php');
exit;
?>
