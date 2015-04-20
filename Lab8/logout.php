<?php
session_start();
session_destroy();
//Logs out the user
header('Location: /~mcpv49/cs3380/lab8/index.php');
?>