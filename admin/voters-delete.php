<?php
require_once "./auxilliaries.php";
require_once "./database/config.php";
// Check if the candidate ID is provided in the URL query string
if (isset($_GET['id']) && isset($_GET['electionid'])) {
    $votersId = $_GET['id'];
    $electionId = $_GET['electionid'];

    //find the name of the candidate's photo
    $voterToBeDel = new Admin($pdo, 'users');
    $results = $voterToBeDel->read("user_id", $votersId);
    $photo = $results[0]['photo'];

    // Unlink the photo
    if ($photo != '') {
        unlink('./assets/uploads/' . $photo);
    }

    // Perform the deletion query using the existing PDO object
    $stmt = $pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
    $stmt->bindParam(':user_id', $votersId, PDO::PARAM_INT);
    $stmt->execute();

    // Redirect to the index.php page after deletion
    header("Location: voters.php?electionid=$electionId");
    exit();
} else {
    // If the candidate ID is not provided, redirect to the index.php page
    header('location: logout.php');
    exit;
}
