<?php
session_start();

require_once "./database/config.php";
require_once "./auxilliaries.php";

if (isset($_SESSION['admin_id']) && isset($_SESSION['isSuperAdmin']) && isset($_SESSION['admin_name'])) {
  // User is logged in
  $AdminName = $_SESSION['admin_name'];
  $isSuperAdmin = $_SESSION['isSuperAdmin'];
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
  $electionTypeResult = $electionType->readWithNoRestriction();
  $electionId = $electionTypeResult[0]['election_id'];
}
//GET DASHBOARD TITLE
$dasboardTitle = $electionType->read("election_id", $electionId);
$title = $dasboardTitle[0]['election_name'];
//Check Election status
$electionStatusNum = $dasboardTitle[0]['election_status'];
if ($electionStatusNum == 1) {
  $btnclass = "btn-danger";
  $btnTxt = "stop election";
} else {
  $btnclass = "btn-primary";
  $btnTxt = "start Election";
}
// Retrieve the number of positions for the specific election
$sqlPositions = "SELECT COUNT(*) AS position_count FROM positions WHERE election_id = :election_id";
$stmtPositions = $pdo->prepare($sqlPositions);
$stmtPositions->bindParam(':election_id', $electionId, PDO::PARAM_INT);
$stmtPositions->execute();
$positionCount = $stmtPositions->fetch(PDO::FETCH_ASSOC)['position_count'];

// Retrieve the number of candidates for the specific election
$sqlCandidates = "SELECT COUNT(DISTINCT candidate_id) AS candidate_count FROM candidates WHERE election_id = :election_id";
$stmtCandidates = $pdo->prepare($sqlCandidates);
$stmtCandidates->bindParam(':election_id', $electionId, PDO::PARAM_INT);
$stmtCandidates->execute();
$candidateCount = $stmtCandidates->fetch(PDO::FETCH_ASSOC)['candidate_count'];


// Retrieve the total number of voters for the specific election
$sqlTotalVoters = "SELECT COUNT(*) AS total_voters FROM users WHERE election_id = :election_id";
$stmtTotalVoters = $pdo->prepare($sqlTotalVoters);
$stmtTotalVoters->bindParam(':election_id', $electionId, PDO::PARAM_INT);
$stmtTotalVoters->execute();
$totalVoters = $stmtTotalVoters->fetch(PDO::FETCH_ASSOC)['total_voters'];

// Retrieve the number of voters who have voted for the specific election
$sqlVotedVoters = "SELECT COUNT(DISTINCT user_id) AS voted_voters FROM votes WHERE candidate_id IN (
  SELECT candidate_id FROM Candidates WHERE election_id = :election_id
)";
$stmtVotedVoters = $pdo->prepare($sqlVotedVoters);
$stmtVotedVoters->bindParam(':election_id', $electionId, PDO::PARAM_INT);
$stmtVotedVoters->execute();
$votedVoters = $stmtVotedVoters->fetch(PDO::FETCH_ASSOC)['voted_voters'];

// Fetch election data from the database
$sqlElections = "SELECT * FROM elections";
$stmtElections = $pdo->prepare($sqlElections);
$stmtElections->execute();
$elections = $stmtElections->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['submitCreateElection'])) {
  $newElectionName = $_POST['electionName'];
  $newElectionStartDate = $_POST['startdate'];
  $newElectionEndDate = $_POST['enddate'];
  $newElection = new Admin($pdo, 'elections');
  if (!empty($newElectionName && $newElectionStartDate && $newElectionEndDate)) {

    $data = [
      'election_name' => $newElectionName,
      'start_date' => $newElectionStartDate,
      'end_date' => $newElectionEndDate
    ];
    $newElection->create($data);
  }
}


$sqlPositions = "SELECT position_id, position_name FROM positions WHERE election_id = :election_id";
$stmtPositions = $pdo->prepare($sqlPositions);
$stmtPositions->bindParam(':election_id', $electionId, PDO::PARAM_INT);
$stmtPositions->execute();
$positions = $stmtPositions->fetchAll(PDO::FETCH_ASSOC);

//  Check if a specific position is selected by the user
$positionName = "";
if (isset($_POST['position_id'])) {
  $selectedPositionId = $_POST['position_id'];
  $positionNameGet = new Admin($pdo, 'positions');
  $nameGetResult = $positionNameGet->read("position_id", $selectedPositionId);
  $positionName = $nameGetResult[0]['position_name'];
}

//Query to get candidate names and their votes for the selected position
$sqlCandidatesVotes = "SELECT candidate_name, votes_count FROM candidates WHERE election_id = :election_id AND position_id = :position_id";
$stmtCandidatesVotes = $pdo->prepare($sqlCandidatesVotes);
$stmtCandidatesVotes->bindParam(':election_id', $electionId, PDO::PARAM_INT);
$stmtCandidatesVotes->bindParam(':position_id', $selectedPositionId, PDO::PARAM_INT);
$stmtCandidatesVotes->execute();
$candidatesData = $stmtCandidatesVotes->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Amanfoo Elections</title>
  <!-- <link rel="icon" href="./assets/img/amanfoo_crest16x16.png"> -->
  <link rel="shortcut icon" href="./assets/img/favicon-32x32.png" type="image/x-icon">
  <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>


</head>

<body class="sb-nav-fixed">
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-success">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="index.php?electionid=<?php echo $electionId ?>">Amanfoo Voting Platform </a>
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
            <a class="nav-link active" href="index.php?electionid=<?php echo $electionId ?>">
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

            <a class="nav-link" href="./voters.php?electionid=<?php echo $electionId ?>">
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
          <h1 class="mt-2"><?php echo $title ?></h1>
          <ol class="breadcrumb mb-4">


            <!-- Modal -->
            <div class="modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New Election</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form action="" method="POST">
                      <div class="card-body">
                        <div class="form-group mb-4">
                          <label for="electioneName">Election Name*</label>
                          <input type="text" class="form-control" id="electioneName" name="electionName" placeholder="Enter the name of election" required>
                        </div>

                        <div class="form-group mb-4">
                          <label for="startDate">Start Date*</label>
                          <input type="date" class="form-control" name="startdate" id="startDate" required>
                        </div>

                        <div class="form-group mb-4">
                          <label for="endDate">End Date*</label>
                          <input type="date" class="form-control" name="enddate" id="endDate" required>
                        </div>


                      </div>
                      <!-- /.card-body -->

                      <div class="card-footer">
                        <button type="submit" name="submitCreateElection" class="btn btn-success mt-4">Add Election</button>
                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>

            <!-- end modal -->

            <div class="container">
              <div class="row">
                <div class="col">
                  <?php
                  if ($isSuperAdmin) {
                    echo '<button class="btn btn-success " data-bs-toggle="modal" data-bs-target="#exampleModal">New Election</button>';
                    echo '<a href="./createAdmins442.php"> <button class="btn btn-info">Add Admin</button></a>';
                    if (isset($_GET['electionid'])) {
                      $electionId = $_GET['electionid'];
                    }
                    $changestatustxt = '<a href="./changeElectionStatus.php?electionid=' . $electionId . '"> <button class="btn ' . $btnclass . '">' . $btnTxt . '</button></a>';
                    echo $changestatustxt;
                  }
                  ?>
                </div>
                <div class="col">
                  <form method="post">
                    <label for="positionSelect">Select a Position:</label>
                    <select id="positionSelect" name="position_id" required>
                      <option value="" selected>select position</option>
                      <?php foreach ($positions as $position) : ?>
                        <option value="<?php echo $position['position_id']; ?>" <?php echo ($selectedPositionId == $position['position_id']) ? 'selected' : ''; ?>>
                          <?php echo $position['position_name']; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                    <button type="submit">Show Chart</button>
                  </form>
                </div>

              </div>
            </div>


          </ol>
          <div class="row">
            <div class="col-xl-3 col-md-6">
              <div class="card bg-info text-white mb-4">
                <div class="card-body">
                  <h1><?php echo $positionCount ?></h1>
                  No. of Positions
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                  <a class="small text-white stretched-link" href="#">View Details</a>
                  <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                  <h1><?php echo $candidateCount ?></h1>
                  Total Candidates
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                  <a class="small text-white stretched-link" href="#">View Details</a>
                  <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card bg-success text-white mb-4">
                <div class="card-body">
                  <h1><?php echo $totalVoters ?></h1>
                  Total Voters
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                  <a class="small text-white stretched-link" href="#">View Details</a>
                  <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-md-6">
              <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                  <h1><?php echo $votedVoters ?></h1>
                  Voters Voted
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                  <a class="small text-white stretched-link" href="#">View Details</a>
                  <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- CHARTS -->
          <h4 style="color: #198754;"><?php echo $positionName ?> Results</h4>
          <div class="row">

            <div class="col-lg-6">
              <div class="card mb-4">
                <div class="card-header">
                  <i class="fas fa-chart-bar me-1"></i>
                  <?php echo $positionName ?> Results Bar Chart
                </div>
                <div class="card-body">
                  <canvas id="myBarChart" width="100%" height="50"></canvas>
                </div>
                <div class="card-footer small text-muted">
                  Updated just now...
                </div>
              </div>
            </div>

            <div class="col-lg-6">
              <div class="card mb-4">
                <div class="card-header">
                  <i class="fas fa-chart-pie me-1"></i>
                  <?php echo $positionName ?> Result Pie Chart
                </div>
                <div class="card-body">
                  <canvas id="myPieChart" width="100%" height="50"></canvas>
                </div>
                <div class="card-footer small text-muted">
                  Updated just now... </div>
              </div>
            </div>

          </div>
          <!-- CHARTS -->


          <div class="row">
            <div class="col-lg-6">
              <div class="card mb-4">
                <table class="table">
                  <thead class="table-warning">
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Candidate</th>
                      <th scope="col">Vote</th>
                      <th scope="col">Result</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Calculate the total number of voters
                    // foreach ($candidatesData as $candidateData) {
                    //   $totalVoters += $candidateData['votes_count'];
                    // }

                    // Calculate and display the table rows for each candidate
                    $count = 1;
                    foreach ($candidatesData as $candidateData) {
                      $candidateName = $candidateData['candidate_name'];
                      $votesCount = $candidateData['votes_count'];

                      // Check if the position has only one candidate
                      $positionHasSingleCandidate = (count($candidatesData) === 1);

                      echo "<tr>";
                      echo "<th>{$count}</th>";
                      echo "<td>{$candidateName}</td>";
                      echo "<td>{$votesCount}</td>";

                      // Display "Yes" or "No" based on the number of candidates and votes
                      if ($positionHasSingleCandidate) {
                        $noVotes = $votedVoters - $votesCount;
                        echo "<td>Yes: {$votesCount}, No: {$noVotes}</td>";
                      } else {
                        echo "<td>Multiple Candidates</td>";
                      }

                      echo "</tr>";

                      $count++;
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>


        </div>
      </main>
      <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
          <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">Copyright &copy; Amanfoo Voting Platform 2023</div>
            <div>
              <a href="https://linktr.ee/charlesbihdev"><small style="margin: 0; text-align: left">Developed By: Snr Charles Bih</small></a>

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
  <script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#ffc107';

    // Bar Chart Example
    var ctx = document.getElementById("myBarChart").getContext('2d');
    var myBarChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: <?php echo json_encode(array_column($candidatesData, 'candidate_name')); ?>,
        datasets: [{
          label: '# of Votes',
          backgroundColor: "rgba(40, 167, 69, 1)",
          borderColor: "rgba(2,117,216,1)",
          data: <?php echo json_encode(array_column($candidatesData, 'votes_count')); ?>,
        }],
      },
      options: {
        // Your options for the chart go here
        scales: {
          xAxes: [{
            time: {
              unit: 'candidate'
            },
            gridLines: {
              display: false
            },
            ticks: {
              maxTicksLimit: 7
            }
          }],
          yAxes: [{
            ticks: {
              min: 0,
              max: <?php echo $totalVoters ?>,
              maxTicksLimit: 5
            },
            gridLines: {
              display: true
            }
          }],
        },
        legend: {
          display: false
        }
      }
    });
  </script>
  <script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#292b2c';

    // Pie Chart Example
    var ctx = document.getElementById("myPieChart");
    var myPieChart = new Chart(ctx, {
      type: 'pie',
      data: {
        labels: <?php echo json_encode(array_column($candidatesData, 'candidate_name')); ?>,
        datasets: [{
          data: <?php echo json_encode(array_column($candidatesData, 'votes_count')); ?>,
          backgroundColor: ['#007bff', '#dc3545', '#ffc107', '#28a745'],
        }],
      },
    });
  </script>
</body>

</html>