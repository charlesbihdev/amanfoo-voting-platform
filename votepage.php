<?php
require_once "./admin/database/config.php";
require_once "./admin/auxilliaries.php";

?>

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
            background-color: red;
        }

        .cardtextSection {
            width: 55%;
            display: flex;
            flex-direction: column;
            justify-content: space-evenly;
            margin-top: 5px;
            margin-left: 8px;
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
    </style>
</head>

<body>
    <nav>

        <p>Amanfoo Voting Platform</p>
    </nav>
    <main>
        <form method="POST" action="">
            <fieldset>
                <!-- President Section -->
                <div>
                    <h3>PRESIDENT</h3>
                    <div class="employeeCard flexItems centerEmployeeCard" onclick="selectCard(this)">
                        <div class="cardChild cardimageSection">
                            <img src="./image_64b865d3b5021.jpg" height="80%" width="90%" class="centerImage" />
                        </div>
                        <div class="cardtextSection">
                            <h2 class="candidateName">Candidate 1</h2>
                            <p class="candidateHouse">House</p>
                            <p class="candidateYear">Year</p>
                            <p class="candidateLocation">Location</p>
                        </div>
                        <div class="radio-section">
                            <input type="radio" class="radio-button" name="president" value="candidate1">
                        </div>
                    </div>

                    <div class="employeeCard flexItems centerEmployeeCard" onclick="selectCard(this)">
                        <div class="cardChild cardimageSection">
                            <img src="./image_64b865d3b5021.jpg" height="80%" width="90%" class="centerImage" />
                        </div>
                        <div class="cardtextSection">
                            <h2 class="candidateName">Candidate 2</h2>
                            <p class="candidateHouse">House</p>
                            <p class="candidateYear">Year</p>
                            <p class="candidateLocation">Location</p>
                        </div>
                        <div class="radio-section">
                            <input type="radio" class="radio-button" name="president" value="candidate2">
                        </div>
                    </div>
                </div>

                <!-- Organizer Section -->
                <div>
                    <h3>ORGANIZER</h3>
                    <div class="employeeCard flexItems centerEmployeeCard" onclick="selectCard(this)">
                        <div class="cardChild cardimageSection">
                            <img src="./image_64b865d3b5021.jpg" height="80%" width="90%" class="centerImage" />
                        </div>
                        <div class="cardtextSection">
                            <h2 class="candidateName">Candidate 3</h2>
                            <p class="candidateHouse">House</p>
                            <p class="candidateYear">Year</p>
                            <p class="candidateLocation">Location</p>
                        </div>
                        <div class="radio-section">
                            <input type="radio" class="radio-button" name="organizer" value="candidate3">
                        </div>
                    </div>

                    <div class="employeeCard flexItems centerEmployeeCard" onclick="selectCard(this)">
                        <div class="cardChild cardimageSection">
                            <img src="./image_64b865d3b5021.jpg" height="80%" width="90%" class="centerImage" />
                        </div>
                        <div class="cardtextSection">
                            <h2 class="candidateName">Candidate 4</h2>
                            <p class="candidateHouse">House</p>
                            <p class="candidateYear">Year</p>
                            <p class="candidateLocation">Location</p>
                        </div>
                        <div class="radio-section">
                            <input type="radio" class="radio-button" name="organizer" value="candidate4">
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <input type="submit" class="btn btn-warning mb-3 mx-auto" value="Submit Vote" name="submit">
                </div>
            </fieldset>
        </form>

        <script>
            // JavaScript to handle adding/removing the "checked" class when cards are clicked
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

</body>

</html>