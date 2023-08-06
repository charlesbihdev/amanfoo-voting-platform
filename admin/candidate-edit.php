<?php
session_start();

require_once "./database/config.php";
require_once "./auxilliaries.php";

if (isset($_SESSION['admin_id'])) {
    // User is logged in
    $AdminName = $_SESSION['admin_name'];
} else {
    // User is not logged in, you can redirect them to the login page
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $candidateId = $_GET['id'];
    $electionId = $_GET['electionid'];

    // Fetch candidate details from the database
    $sqlCandidate = "SELECT
        candidate_name,
        candidate_phone,
        election_id,
        candidate_yeargroup,
        candidate_house,
        candidate_class,
        photo,
        position_id
        FROM candidates
        WHERE candidate_id = :candidate_id";
    $stmtCandidate = $pdo->prepare($sqlCandidate);
    $stmtCandidate->bindParam(':candidate_id', $candidateId, PDO::PARAM_INT);
    $stmtCandidate->execute();
    $candidate = $stmtCandidate->fetch(PDO::FETCH_ASSOC);
    if (!$candidate) {
        // Candidate not found, redirect or display an error message
        header("Location: ./index.php");
    }
} else {
    header("Location: ./index.php");

    // Candidate ID not provided, redirect or display an error message
}

// Fetch positions available for a candidate
$sqlPositions = "SELECT * FROM positions WHERE election_id = :election_id";
$stmtPositions = $pdo->prepare($sqlPositions);
$stmtPositions->bindParam(':election_id', $candidate['election_id'], PDO::PARAM_INT);
$stmtPositions->execute();
$positions = $stmtPositions->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission for updating candidate
if (isset($_POST['editCandidateSubmit'])) {
    $selectedPosition = $_POST['position'];
    $editedCandidateName = $_POST['candidateName'];
    // $editedCandidatePhone = $_POST['candidatePhone'];
    $editedCandidateClass = $_POST['candidateClass'];
    $editedCandidateHouse = $_POST['candidateHouse'];
    $editedCandidateYear = $_POST['candidateYear'];
    $path = $_FILES['photo']['name'];


    if (!empty($selectedPosition) && !empty($editedCandidateName) && !empty($path)) {
        // Handle image upload
        $image = $_FILES['photo'];
        $destinationDirectory = './assets/uploads';
        $uploadedImage = uploadImage($image, $destinationDirectory);
        if ($candidate['photo'] != '') {
            unlink('./assets/uploads/' . $candidate['photo']);
        }
        // Update candidate details in the database
        $sqlUpdateCandidate = "UPDATE candidates SET
            candidate_name = :candidate_name,
            -- candidate_phone = :candidate_phone,
            photo = :photo,
            candidate_class = :candidate_class,
            candidate_house = :candidate_house,
            candidate_yeargroup = :candidate_yeargroup,
            position_id = :position_id
            WHERE candidate_id = :candidate_id";
        $stmtUpdateCandidate = $pdo->prepare($sqlUpdateCandidate);
        $stmtUpdateCandidate->bindParam(':candidate_name', $editedCandidateName, PDO::PARAM_STR);
        // $stmtUpdateCandidate->bindParam(':candidate_phone', $editedCandidatePhone, PDO::PARAM_STR);
        $stmtUpdateCandidate->bindParam(':candidate_class', $editedCandidateClass, PDO::PARAM_STR);
        $stmtUpdateCandidate->bindParam(':candidate_house', $editedCandidateHouse, PDO::PARAM_STR);
        $stmtUpdateCandidate->bindParam(':photo', $uploadedImage, PDO::PARAM_STR);
        $stmtUpdateCandidate->bindParam(':candidate_yeargroup', $editedCandidateYear, PDO::PARAM_STR);
        $stmtUpdateCandidate->bindParam(':position_id', $selectedPosition, PDO::PARAM_INT);
        $stmtUpdateCandidate->bindParam(':candidate_id', $candidateId, PDO::PARAM_INT);
        $stmtUpdateCandidate->execute();

        if ($stmtUpdateCandidate->execute()) {
            $message = "Update Successful";
            header("Location: ./candidates.php?electionid={$electionId}");
        } else {
            $message = "Unable to update. Try again";
        }

        // Redirect or display success message
    } else {
        $message = "Unable to update. Please fill all required fields.";
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
    <title>Amanfoo Voting Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-success">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">Amanfoo Voting Platform </a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
                <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                <button class="btn btn-warning" id="btnNavbarSearch" type="button">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="#!">Settings</a></li>
                    <li><a class="dropdown-item" href="#!">Activity Log</a></li>
                    <li>
                        <hr class="dropdown-divider" />
                    </li>
                    <li><a class="dropdown-item" href="#!">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Core</div>
                        <a class="nav-link" href="./index.php">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Manage Elections</div>
                        <a class="nav-link" href="./position.php">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-chart-area"></i>
                            </div>
                            Position
                        </a>
                        <a class="nav-link active" href="./candidates.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Candidates
                        </a>

                        <a class="nav-link" href="./voters.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Voters
                        </a>

                        <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-columns"></i>
                            </div>
                            Choose Election
                            <div class="sb-sidenav-collapse-arrow">
                                <i class="fas fa-angle-down"></i>
                            </div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <?php
                                foreach ($elections as $election) {
                                    $electionId = $election['election_id'];
                                    $electionName = $election['election_name'];

                                    // Render the link with the election ID as a query string
                                    echo '<a class="nav-link" href="./index.php?electionid=' . $electionId . '">' . $electionName . '</a>';
                                }
                                ?>
                            </nav>
                        </div>

                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo $AdminName ?>

                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                <h4 class="text-danger" style="margin-left: 5px; margin-top: 5px;"> <?php if (isset($message)) {
                                                                                        echo $message;
                                                                                    } ?></h4>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Edit Candidates</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Candidates</li>
                    </ol>


                    <div class="card mb-4">
                        <div class="card-header">
                            <div class="" id="" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="false">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Candidate</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form method="POST" action="" enctype="multipart/form-data">
                                                <div class="card-body">
                                                    <div class="form-group mb-4">
                                                        <label for="candidateName">Candidate Name</label>
                                                        <input type="text" class="form-control" id="candidateName" name="candidateName" value="<?php echo $candidate['candidate_name']; ?>" required>
                                                    </div>
                                                    <!-- <div class="form-group mb-4">
                                                        <label for="candidatePhone">Candidate Phone</label>
                                                        <input type="tel" class="form-control" id="candidatePhone" name="candidatePhone" value="<?php echo $candidate['candidate_phone']; ?>" required>
                                                    </div> -->
                                                    <div class="form-group mb-4">
                                                        <label for="candidateClass">Candidate Location</label>
                                                        <input type="text" class="form-control" id="candidateClass" name="candidateClass" value="<?php echo $candidate['candidate_class']; ?>" required>
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label for="candidateHouse">Candidate House</label>
                                                        <input type="text" class="form-control" id="candidateHouse" name="candidateHouse" value="<?php echo $candidate['candidate_house']; ?>" required>
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label for="candidateYear">Candidate Year</label>
                                                        <input type="text" class="form-control" id="candidateYear" name="candidateYear" value="<?php echo $candidate['candidate_yeargroup']; ?>" required>
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label for="photo">Candidate Photo</label>
                                                        <input type="file" class="form-control" id="photo" name="photo" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="position">Select Position</label>
                                                        <select class="form-select" id="position" name="position" required>
                                                            <option value="">Select Position</option>
                                                            <?php foreach ($positions as $position) {
                                                                $positionId = $position['position_id'];
                                                                $positionName = $position['position_name'];
                                                                $selected = ($positionId == $candidate['position_id']) ? 'selected="selected"' : '';

                                                                echo '<option value="' . $positionId . '" ' . $selected . '>' . $positionName . '</option>';
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <button type="submit" name="editCandidateSubmit" class="btn btn-primary mt-4">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end of Create Modal -->

                        </div>
                    </div>
                </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Amanfoo Voting 2023</div>
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

    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <?php
    require_once "./inc/footer.php";
    ?>
</body>

</html>