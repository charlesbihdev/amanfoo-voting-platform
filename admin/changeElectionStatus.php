<?php
session_start();
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['isSuperAdmin']) || !isset($_SESSION['admin_name']) || !isset($_GET['electionid'])) {
    // User is logged in
    echo "you visited an unauthorized page";
    exit;
}

require_once "./database/config.php";
require_once "./auxilliaries.php";
$electionId = $_GET['electionid'];

$getElections = new Admin($pdo, 'elections');
// Toggle the election status using SQL query
// $query = "UPDATE elections SET election_status = NOT election_status";
$query = "UPDATE elections SET election_status = !election_status WHERE election_id = :electionid";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':electionid', $electionId, PDO::PARAM_INT);
$stmt->execute();

header("location: index.php?electionid={$electionId}");
