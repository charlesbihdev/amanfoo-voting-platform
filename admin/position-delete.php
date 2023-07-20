<?php
require_once "./auxilliaries.php";
require_once "./database/config.php";

// Check if the position ID and election ID are provided in the URL query string
if (isset($_GET['id']) && isset($_GET['electionid'])) {
    $positionId = $_GET['id'];
    $electionId = $_GET['electionid'];

    // Perform the deletion query using the existing PDO object
    $stmt = $pdo->prepare("DELETE FROM positions WHERE position_id = :positionId");
    $stmt->bindParam(':positionId', $positionId, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect to the position.php page for the specified election after deletion
    header("Location: position.php?electionid=$electionId");
    exit();
} else {
    // If the position ID or election ID is not provided, redirect to the position.php page
    header("Location: position.php");
    exit();
}
