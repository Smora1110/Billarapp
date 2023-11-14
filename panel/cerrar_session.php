<?php

session_start();
$_SESSION = array();
session_destroy();
$_SESSION['usuario_info'] =array();
header('Location: ../index.php');