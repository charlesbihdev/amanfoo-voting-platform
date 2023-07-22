<?php
require_once "./admin/database/config.php";

session_start();
include 'config.php';
unset($_SESSION['user_id']);
unset($_SESSION['election_id']);
header("location: login.php");
