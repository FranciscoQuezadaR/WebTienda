<?php
include_once '../../../proyectoWeb/includes/config/user_session.php';

$userSession = new userSession();
$userSession -> closeSession();

?><script>window.location.href = "../../../../../proyectoWeb/index.php";</script><?php
?>