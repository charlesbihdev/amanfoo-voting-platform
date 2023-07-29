<?php
session_start();

require_once "./database/config.php";
require_once "./auxilliaries.php";

if (isset($_SESSION['admin_id']) && isset($_SESSION['isSuperAdmin']) && isset($_SESSION['admin_name'])) {
    // User is logged in
    $AdminName = $_SESSION['admin_name'];
    $isSuperAdmin = $_SESSION['isSuperAdmin'];
    $isSuperAdmin != 1 ? $hideIfNotAdmin = "hideIfNotAdmin" : $hideIfNotAdmin = "";
} else {
    // User is not logged in, you can redirect them to the login page
    header("Location: login.php");
    exit();
}

$electionType = new Admin($pdo, 'elections');
if (isset($_GET['electionid'])) {
    $electionId = $_GET['electionid'];
    $electionTypeResult = $electionType->read("election_id", $electionId);
} else {
    $electionTypeResult = $electionType->readAll("election_id");
    $electionId = $electionTypeResult[count($electionTypeResult) - 1]['election_id'];
}
$electionTypeResult = $electionType->read("election_id", $electionId);
$currentElectionName = $electionTypeResult[0]['election_name'];

// Fetch election data from the database
$sqlElections = "SELECT * FROM elections";
$stmtElections = $pdo->prepare($sqlElections);
$stmtElections->execute();
$elections = $stmtElections->fetchAll(PDO::FETCH_ASSOC);


// Fetch voters' data from the database
$sqlVoters = "SELECT u.*, COUNT(v.vote_id) AS vote_count
              FROM users u
              LEFT JOIN votes v ON u.user_id = v.user_id
              WHERE u.election_id = :election_id
              GROUP BY u.user_id";

$stmtVoters = $pdo->prepare($sqlVoters);
$stmtVoters->bindValue(':election_id', $electionId, PDO::PARAM_INT);
$stmtVoters->execute();
$voters = $stmtVoters->fetchAll(PDO::FETCH_ASSOC);


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
    <style>
        .hideIfNotAdmin {
            visibility: hidden;
        }
    </style>
</head>

<body class="sb-nav-fixed">
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-success">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.php">Amanfoo Voting Platform</a>
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
                    <li><a class="dropdown-item" href="./logout.php">Logout</a></li>
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
                        <a class="nav-link" href="./index.php?electionid=<?php echo $electionId ?>">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Manage Elections</div>
                        <a class="nav-link" href="./position.php?electionid=<?php echo $electionId ?>">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-chart-area"></i>
                            </div>
                            Position
                        </a>
                        <a class="nav-link" href="./candidates.php?electionid=<?php echo $electionId ?>">
                            <div class="sb-nav-link-icon"><i class="fas fa-table"></i></div>
                            Candidates
                        </a>

                        <a class="nav-link active" href="./voters.php?electionid=<?php echo $electionId ?>">
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
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Manage Voters</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active"><?php echo $currentElectionName ?></li>
                    </ol>


                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-table me-1"></i>
                            Registered Voters
                        </div>
                        <div class="card-body">
                            <table class="table-striped" id="datatablesSimple">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Voter ID</th>
                                        <th>Voted</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" id="myModalLabel">Delete Confirmation</h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure want to delete this item?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                <a class="btn btn-danger btn-ok">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <tfoot>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Photo</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Voter ID</th>
                                        <th>Voted</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($voters as $index => $voter) { ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td><img style="width: 100px;" src="./assets/uploads/<?php echo $voter['photo']; ?>" alt="Voter Photo"></td>
                                            <td><?php echo $voter['name']; ?></td>
                                            <td><?php echo $voter['email']; ?></td>
                                            <td><?php echo $voter['voter_id']; ?></td>
                                            <td><?php echo $voter['vote_count'] > 0 ? 'Yes' : 'No'; ?></td>
                                            <td>
                                                <a href="#" data-href="voters-delete.php?id=<?php echo $voter['user_id'] . "&electionid=" . $_GET['electionid'] ?>" class="btn btn-danger btn-xs <?php echo $hideIfNotAdmin ?>" data-toggle="modal" data-target="#confirm-delete">Delete</a>

                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
    <?php
    require_once "./inc/footer.php";
    ?>
</body>

</html>