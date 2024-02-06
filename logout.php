<?php
session_start();
session_destroy();  // Beëindig de sessie
header("Location: login.php");  // Omleiden naar de loginpagina
exit;
?>
