<?php
require_once "./admin/database/config.php";
require_once "./admin/auxilliaries.php";

$alert = "";



$electionsFetch = new Admin($pdo, 'elections');
$elections = $electionsFetch->readAll("election_id");

// Step 2: Check if the form is submitted
if (isset($_POST['submit'])) {
    // Step 3: Get form data
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $house = $_POST['house'];
    $location = $_POST['location'];
    $selectedElectionId = $_POST['election'];

    // Step 4: Validate and handle image upload
    $photo = $_FILES['photo'];
    $destinationDirectory = './admin/assets/uploads';
    $uploadedImage = uploadImage($photo, $destinationDirectory);

    // Generate a random voter ID and append the selected election ID to it
    $voterId = generateRandomString(6) . $selectedElectionId;

    // Handle unavailable info (whether null or empty)
    $candidateVotedForId = null; // or set to the appropriate value
    $positionId = null; // or set to the appropriate value

    if (!empty($fullname) && !empty($email) && !empty($house) && !empty($location) && !empty($selectedElectionId) && $uploadedImage) {
        // Step 5: Insert the data into the Candidates table, including the file name
        $newUser = new Admin($pdo, 'users');
        $data = [
            'name' => $fullname,
            'photo' => $uploadedImage,
            'email' => $email,
            'voter_id' => $voterId,
            'house' => $house,
            'location' => $location,
            'candidate_voted_for_id' => $candidateVotedForId,
            'election_id' => $selectedElectionId
        ];
        $newUser->create($data);
        // $newUserRead->read("email", $email);
        // $user
        // print_r($newUserRead);

        // Display success message or redirect to a success page
        $alert = "showAlert('success', 'Candidate created successfully!')";
        header("Location: ./viewvoterid.php?voterid={$voterId}");
    } else {
        // Display error message or redirect back to the form page with an error message
        $alert = "showAlert('error', 'Error: Please fill all required fields and upload a valid photo.')";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Voting - Registration</title>
    <link href="./admin/css/styles.css" rel="stylesheet" />
    <link rel="stylesheet" href="./admin/inc/style.css" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./admin/inc/sweetalert.js"> </script>
</head>

<body class="bg-success">
    <?php
    echo "<script>";
    echo $alert;
    echo "</script>";
    ?>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content" class="mb-4">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4 text-success">Register To Vote</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="" enctype="multipart/form-data">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="fullname" type="text" name="fullname" placeholder="Enter your full name" required />
                                            <label for="fullname">Fullname</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="email" type="email" placeholder="Enter your email" name="email" required />
                                            <label for="email">Email</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="photo" name="photo" type="file" required />
                                            <label for="photo">Upload your Photo</label>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="house" type="text" name="house" placeholder="Choose your House" required />
                                                    <label for="house">House</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating">
                                                    <input class="form-control" id="location" type="text" placeholder="Enter your Location" name="location" required />
                                                    <label for="location">Location</label>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" type="email" placeholder="name@example.com" />
                                            <label for="inputEmail">Email address</label>
                                        </div> -->
                                        <div class="row mb-3">
                                            <div class="form-floating mb-3">
                                                <select class="form-select" id="election" name="election" required>
                                                    <option value="" selected>Select Election</option>
                                                    <?php foreach ($elections as $election) : ?>
                                                        <option value="<?php echo $election['election_id']; ?>"><?php echo $election['election_name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <label for="election">Election</label>
                                            </div>
                                            <!-- <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" id="inputPasswordConfirm" type="text" placeholder="auto generated" value="x3mlRAM" readonly />
                                                    <label for="inputPasswordConfirm">Voter ID</label>
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid"><input type="submit" class="btn btn-warning btn-block" value="Create Account" name="submit"></input></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="login.php">Have an account? Go to login</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Amanfoo Voting Platform 2023</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>