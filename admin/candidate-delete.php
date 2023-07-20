<?php
require_once "./auxilliaries.php";
require_once "./database/config.php";
// Check if the candidate ID is provided in the URL query string
if (isset($_GET['id']) && isset($_GET['electionid'])) {
    $candidateId = $_GET['id'];
    $electionId = $_GET['electionid'];

    // Perform the deletion query using the existing PDO object
    $stmt = $pdo->prepare("DELETE FROM candidates WHERE candidate_id = :candidate_id");
    $stmt->bindParam(':candidate_id', $candidateId, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect to the index.php page after deletion
    header("Location: candidates.php?electionid=$electionId");
    exit();
} else {
    // If the candidate ID is not provided, redirect to the index.php page
    header("Location: candidates.php");
    exit();
}
