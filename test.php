<?php
require_once "./admin/database/config.php";
require_once "./admin/auxilliaries.php";

if (isset($_SESSION['user_id'])) {
    // User is logged in
    // You can access the user ID and other information from session variables like this:
    $user_id = $_SESSION['user_id'];
    $election_id = $_SESSION['election_id'];
    // ... (other user-specific operations)
} else {
    // User is not logged in, you can redirect them to the login page
    header("Location: login.php");
    exit();
}


// Step 1: Fetch candidates based on their positions and the election_id
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

// Check if the form has been submitted
if (isset($_POST["submit"])) {
    $selectedCandidates = []; // Initialize an array to store the selected candidate IDs

    foreach ($_POST as $key => $value) {
        // Check if the key contains the position ID (e.g., 'position_2')
        if (strpos($key, 'position_') === 0) {
            // Extract the position ID from the key
            $position_id = intval(substr($key, strlen('position_')));

            // Store the selected candidate ID for the corresponding position ID
            $selectedCandidates[$position_id] = intval($value);
        }
    }

    // Process the form data and update the vote count
    foreach ($selectedCandidates as $position_id => $selectedCandidateId) {
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

        // Redirect the user to a "Thank You" page or any other page after voting is successful
        header("Location: thank_you.php");
        exit();
    }
}

?>

<!-- Your HTML code -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Amanfoo - Vote Page</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }

        a {
            text-decoration: none;
        }

        body {
            background-color: #f5f5f5;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
                Oxygen, Ubuntu, Cantarell, "Open Sans", "Helvetica Neue", sans-serif;
        }

        .flexItems {
            display: flex;
        }

        nav {
            text-align: center;
            padding: 10px 20px;
            height: 50px;
            font-weight: bold;
            font-size: x-large;
            background-color: #ffc107;
            border-radius: 3px;
            color: #28a745;
            margin-bottom: 7px;
        }



        .employeeCard {
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 13px;
            width: 96%;
            margin: 20px auto;
            background-color: #ffffff;
            box-shadow: 0.2rem 0.4rem 12rem rgba(0, 0, 0, 0.08);
        }

        @media screen and (min-width: 992px) {
            .employeeCard {
                width: 520px;
                height: 180px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            h3 {
                text-align: center;
                color: #28a745;
            }

            .centerImage {
                margin-top: 15px !important;
            }

        }

        h3 {
            text-align: center;
            color: #28a745;
        }

        .centerImage {
            display: block;
            margin: auto;
            border-radius: 10px;
        }

        .cardChild {
            height: 100%;
        }

        .cardimageSection {
            width: 35%;
            height: 100%;
        }

        .radio-section {
            width: 10%
        }

        .radio-button {
            width: 30px;
            height: 30px;
        }

        .cardtextSection {
            width: 55%;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            margin-top: 5px;
            margin-left: 8px;
        }

        .submit-btn {
            border: 3px solid #28a745;
            font-size: large;
        }

        .cardtextSection p {
            font-size: larger;
            color: rgb(116, 116, 201);
            font-weight: 500;
        }

        /* Your existing styles */

        .employeeCard {
            border: 1px solid #ccc;
            /* Default border color for the card */
        }

        /* Updated style to apply blue border for checked cards */
        .employeeCard.checked {
            border: 2px solid #28a745;
            /* Blue border color for the checked card */
        }
    </style>
</head>

<body>
    <nav>

        <p>Amanfoo Voting Platform</p>
    </nav>
    <!-- Your form and other HTML elements -->
    <form method="POST" action="">
        <fieldset>
            <?php foreach ($positions as $position_id => $candidates) : ?>
                <h3><?php echo get_position_name_by_id($position_id); ?></h3>
                <?php foreach ($candidates as $candidate) : ?>
                    <div class="employeeCard flexItems centerEmployeeCard" onclick="selectCard(this)">
                        <!-- Display candidate information here -->
                        <div class="cardimageSection">
                            <img src="<?php echo $candidate['photo']; ?>" height="80%" width="90%" class="centerImage" />
                        </div>
                        <div class="cardtextSection">
                            <h2 class="candidateName"><?php echo $candidate['candidate_name']; ?></h2>
                            <p class="candidateHouse"><?php echo $candidate['candidate_house']; ?></p>
                            <p class="candidateYear"><?php echo $candidate['candidate_yeargroup']; ?></p>
                            <p class="candidateLocation"><?php echo $candidate['candidate_class']; ?></p>
                        </div>
                        <div class="radio-section">
                            <input type="radio" class="radio-button" name="position_<?php echo $position_id; ?>" value="<?php echo $candidate['candidate_id']; ?>">
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>

            <!-- Your submit button -->
            <div class="col-md-12 d-flex justify-content-center">
                <input type="submit" class="submit-btn btn btn-warning mb-3" value="Submit Vote" name="submit">
            </div>
        </fieldset>
    </form>

    <!-- Your JavaScript code -->
    <script>
        // Your existing JavaScript code for handling the "checked" class
        function selectCard(card) {
            const radio = card.querySelector(".radio-button");
            const cardsInSection = card.parentElement.querySelectorAll(".employeeCard");

            cardsInSection.forEach((cardInSection) => {
                cardInSection.classList.remove("checked");
                const radioInSection = cardInSection.querySelector(".radio-button");
                if (radioInSection !== radio) {
                    radioInSection.checked = false;
                }
            });

            card.classList.add("checked");
            radio.checked = true;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

    </script>

    <!-- Your Bootstrap and other scripts -->
</body>

</html>