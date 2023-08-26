<?php
session_start();

require_once "./admin/database/config.php";
require_once "./admin/auxilliaries.php";

if (isset($_SESSION['user_id'])) {
    // User is logged in
    // You can access the user ID and other information from session variables like this:
    $user_id = $_SESSION['user_id'];
    $election_id = $_SESSION['election_id'];
} else {
    // User is not logged in, you can redirect them to the login page
    header("Location: login.php");
    exit();
}
// Create a new instance of Admin class and fetch election based on election id
$getElections = new Admin($pdo, 'elections');
$electionFilterById = $getElections->read("election_id", $election_id);
$electionStatusNum = $electionFilterById[0]['election_status'];
if ($electionStatusNum != 1) {
    header('location: ./election-unavailable.php');
}
// Fetch voters' data from the database
$sqlVoters = "SELECT u.*, COUNT(v.vote_id) AS vote_count
              FROM users u
              LEFT JOIN votes v ON u.user_id = v.user_id
              WHERE u.user_id = :user_id
              GROUP BY u.user_id";

$stmtVoters = $pdo->prepare($sqlVoters);
$stmtVoters->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmtVoters->execute();
$voters = $stmtVoters->fetchAll(PDO::FETCH_ASSOC);
$userfullname = $voters[0]['name'];
$useremail = $voters[0]['email'];


if ($voters[0]['vote_count'] > 0) {
    // User is already voted, redirect them to the already voted page
    header("Location: alreadyvoted.php");
    exit();
}

// Fetch candidates based on their positions and the election_id
$sql = "SELECT * FROM candidates WHERE election_id = :election_id ORDER BY position_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':election_id', $election_id, PDO::PARAM_INT);
$stmt->execute();
$candidates = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Step 2: Display the candidates grouped by their positions
$positions = []; // Create an array to store candidates by position
foreach ($candidates as $candidate) {
    $position_id = $candidate['position_id'];
    if (!isset($positions[$position_id])) {
        $positions[$position_id] = []; // Initialize an array for each position
    }
    $positions[$position_id][] = $candidate; // Add the candidate to the corresponding position array
}


if (isset($_POST["submit"])) {
    // Process the form data and insert a new record into the votes table
    foreach ($positions as $position_id => $candidates) {
        if (count($candidates) === 1) {
            // For single candidate positions
            if (isset($_POST['yes_no_' . $position_id])) {
                $voteValue = $_POST['yes_no_' . $position_id];
                if ($voteValue === "yes") {
                    $selectedCandidateId = $candidates[0]['candidate_id'];

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
                }
            }
        } else {
            // For multiple candidate positions
            if (isset($_POST['position_' . $position_id])) {
                $selectedCandidateId = intval($_POST['position_' . $position_id]);

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
            }
        }
    }

    // Redirect the user to a "Thank You" page or any other page after voting is successful
    header("Location: thank_you.php?name={$userfullname}&email={$useremail}");
    exit();
}
?>
<!-- Your HTML code -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="./admin/assets/img/favicon-32x32.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="./vote-style/style.css">
    <title>Amanfoo - Vote Page</title>

</head>

<body>
    <nav>

        <p>Amanfoo Voting Platform</p>
    </nav>
    <audio autoplay>
        <source src="./admin/assets/audio/prempeh_anthem.mp3" type="audio/mp3" controls />
        Your browser does not support the audio element.
    </audio>
    <!-- Your form and other HTML elements -->
    <form method="POST" action="">
        <?php foreach ($positions as $position_id => $candidates) : ?>
            <?php if (count($candidates) === 1) : ?>
                <!-- Show Yes/No options within the single candidate card -->
                <h3><?php echo get_position_name_by_id($position_id); ?></h3>
                <?php foreach ($candidates as $candidate) : ?>
                    <div class="employeeCard flexItems centerEmployeeCard">
                        <!-- Display candidate information here -->
                        <div class="cardimageSection">
                            <img src="./admin/assets/uploads/<?php echo $candidate['photo']; ?>" height="80%" width="90%" class="centerImage" />
                        </div>
                        <div class="cardtextSection">
                            <h4 class="candidateName"><?php echo $candidate['candidate_name']; ?></h3>
                                <p class="candidateHouse"><?php echo $candidate['candidate_house']; ?></p>
                                <p class="candidateYear"><?php echo $candidate['candidate_yeargroup']; ?></p>
                                <p class="candidateLocation"><?php echo $candidate['candidate_class']; ?></p>
                        </div>
                        <div class="radio-section">
                            <label for="yes_<?php echo $position_id; ?>">
                                Yes
                                <input type="radio" id="yes_<?php echo $position_id; ?>" class="radio-button" name="yes_no_<?php echo $position_id; ?>" value="yes" required <?php if (isset($_POST['yes_no_' . $position_id]) && $_POST['yes_no_' . $position_id] === 'yes') echo 'checked'; ?>>
                            </label>
                            <label for="no_<?php echo $position_id; ?>">
                                No
                                <input type="radio" id="no_<?php echo $position_id; ?>" class="radio-button" name="yes_no_<?php echo $position_id; ?>" value="no" required <?php if (isset($_POST['yes_no_' . $position_id]) && $_POST['yes_no_' . $position_id] === 'no') echo 'checked'; ?>>
                            </label>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <!-- Show candidate cards when there are multiple candidates -->
                <h3><?php echo get_position_name_by_id($position_id); ?></h3>
                <?php foreach ($candidates as $candidate) : ?>
                    <div class="employeeCard flexItems centerEmployeeCard" onclick="selectCard(this)">
                        <!-- Display candidate information here -->
                        <div class="cardimageSection">
                            <img src="./admin/assets/uploads/<?php echo $candidate['photo']; ?>" height="80%" width="90%" class="centerImage" />
                        </div>
                        <div class="cardtextSection">
                            <h4 class="candidateName"><?php echo $candidate['candidate_name']; ?></h4>
                            <p class="candidateHouse"><?php echo $candidate['candidate_house']; ?></p>
                            <p class="candidateYear"><?php echo $candidate['candidate_yeargroup']; ?></p>
                            <p class="candidateLocation"><?php echo $candidate['candidate_class']; ?></p>
                        </div>
                        <div class="radio-section">
                            <input type="radio" class="radio-button" name="position_<?php echo $position_id; ?>" value="<?php echo $candidate['candidate_id']; ?>" required>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <!-- Your submit button -->
        <div class="col-md-12 d-flex justify-content-center">
            <input type="submit" class="submit-btn btn btn-warning mb-3" value="Submit Vote" name="submit">
        </div>
    </form>
    <!-- Your JavaScript code -->
    <script>
        function selectCard(card) {
            const radio = card.querySelector(".radio-button");
            const cardsInSection = card.parentElement.querySelectorAll(".employeeCard");

            cardsInSection.forEach((cardInSection) => {
                const radioInSection = cardInSection.querySelector(".radio-button");
                if (radioInSection.name === radio.name) {
                    // Check if the radio button belongs to the same group
                    if (radioInSection !== radio) {
                        radioInSection.checked = false;
                        cardInSection.classList.remove("checked");
                    } else {
                        cardInSection.classList.toggle("checked"); // Toggle the "checked" class on click
                        radio.checked = cardInSection.classList.contains("checked"); // Check/uncheck the radio button accordingly
                    }
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    </script>

    <!-- Your Bootstrap and other scripts -->
</body>

</html>