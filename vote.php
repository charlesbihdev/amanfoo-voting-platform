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
    <link rel="stylesheet" href="./vote-style/style.css" />
    <link href="./admin/css/styles.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Namibra - Crud App</title>
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
            height: 60px;
            font-weight: bold;
            font-size: x-large;
            background-color: #e1e0e0;
            border-radius: 3px;
        }



        .employeeCard {
            justify-content: center;
            align-items: center;
            border-radius: 13px;
            height: 180px;
            width: 100%;
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
            width: 40%;
            height: 75%;
        }

        .cardtextSection {
            width: 60%;
            display: flex;
            flex-direction: column;
            justify-content: space-around;
        }

        .cardtextSection p {
            font-size: larger;
            color: rgb(116, 116, 201);
            font-weight: 500;
        }

        .cardtextSection h2 {
            margin-top: 15px;
        }



        .icons {
            font-size: x-large;
        }

        .fa-pen-to-square {
            color: rgb(116, 116, 201);
        }

        .fa-trash-can {
            color: red;
        }

        .iconsDiv {
            justify-content: space-between;
        }
    </style>
</head>

<body>
    <nav>

        <p>Amanfoo Voting Platform</p>
    </nav>
    <main>
        <div>
            <h2 class="my-3">PRESIDENT</h2>
        </div>

        <!-- INDIVIDUAL CARD ITEMS -->


        <div class="employeeCard flexItems centerEmployeeCard">
            <div class="cardChild cardimageSection">
                <img src="./image_64b865d3b5021.jpg" height="100%" width="80%" class="centerImage" />
            </div>
            <div class="cardChild cardtextSection">
                <h2 class="employeeName">Charle Bih</h2>
                <p class="employeePosition"> House</p>
                <p class="employeePosition"> Year</p>
                <p class="employeeAge">Location</p>

            </div>
        </div>

        <!-- END OF CARD ITEM -->
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>

</html>