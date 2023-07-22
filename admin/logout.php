<?php
require_once "./database/config.php";

session_start();
unset($_SESSION['admin_id']);
unset($_SESSION['admin_name']);
header("location: login.php");
exit();
