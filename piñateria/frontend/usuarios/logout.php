<?php
session_start();
session_destroy(); // destruir todas las variables de sesión
header("Location: login.php");
exit;
