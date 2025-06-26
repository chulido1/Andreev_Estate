<?php
session_start();
session_destroy();
header("Location: personal-account.php");
exit();
?>
