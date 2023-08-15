<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Already Voted</title>
    <link rel="shortcut icon" href="./assets/img/favicon-32x32.png" type="image/x-icon">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 30px;
        }

        .container {
            max-width: 600px;
            margin: auto;
        }

        .thank-you-heading {
            color: #28a745;
            /* Success color */
            text-align: center;
            margin-top: 50px;
            margin-bottom: 20px;
        }

        .thank-you-message {
            font-size: 20px;
            text-align: center;
            color: #343a40;
            /* Dark color for text */
        }

        .btn-continue {
            display: block;
            width: 100%;
            max-width: 300px;
            margin: auto;
            margin-top: 30px;
            background-color: #ffc107;
            /* Warning color */
            color: #343a40;
            /* Dark color for text */
            font-weight: bold;
            text-align: center;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.2s ease-in-out;
        }

        .btn-continue:hover {
            background-color: #ffca3a;
            /* Lighter shade of warning color on hover */
            color: #343a40;
            /* Dark color for text */
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="thank-you-heading">You have already Voted!</h1>
        <p class="thank-you-message">Your vote has been submitted successfully.</p>
        <a href="#" class="btn-continue">You can exit</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>