// ... (Previous code)
<?php
if (isset($_POST["submit"])) {
    $selectedCandidates = []; // Initialize an array to store the selected candidate IDs

    foreach ($_POST as $key => $value) {
        // Check if the key contains the position ID (e.g., 'position_2')
        if (strpos($key, 'position_') === 0) {
            // Extract the position ID from the key
            $position_id = intval(substr($key, strlen('position_')));

            // Check if there is only one candidate for this position
            if (count($positions[$position_id]) === 1) {
                // If there's only one candidate, the value submitted should be "yes" or "no"
                if (isset($_POST['yes_no_' . $position_id])) {
                    $voteValue = $_POST['yes_no_' . $position_id];

                    if ($voteValue === "yes") {
                        $selectedCandidates[$position_id] = $positions[$position_id][0]['candidate_id'];
                    } else {
                        $selectedCandidates[$position_id] = null; // Set to null if "no" is selected
                    }
                }
            } else {
                // If there are multiple candidates, store the selected candidate ID for the corresponding position ID
                if (isset($_POST['position_' . $position_id])) {
                    $selectedCandidates[$position_id] = intval($_POST['position_' . $position_id]);
                }
            }
        }
    }

    // Process the form data and update the vote count
    foreach ($selectedCandidates as $position_id => $selectedCandidateId) {
        if ($selectedCandidateId !== null) {
            // Update the vote count for the selected candidate
            $sql = "UPDATE candidates SET votes_count = votes_count + 1 WHERE candidate_id = :candidate_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':candidate_id', $selectedCandidateId, PDO::PARAM_INT);
            $stmt->execute();

            // Insert a new record into the votes table
            $sql = "INSERT INTO votes (user_id, candidate_id) VALUES (:user_id, :candidate_id)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT); // Replace $user_id with the actual user ID of the voter
            $stmt->bindParam(':candidate_id', $selectedCandidateId, PDO::PARAM_INT);
            $stmt->execute();

            // You can also store the user's vote information in the database if needed
            // For example, you can create a 'votes' table and insert a new vote record with the user_id and selected candidate_id
            // This allows you to keep track of each user's vote history
        }
    }

    // Redirect the user to a "Thank You" page or any other page after voting is successful
    header("Location: thank_you.php");
    exit();
}
}
?>