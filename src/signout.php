<?php
session_start();
require_once('../includes/authentication.php');
$auth->signout();
?>