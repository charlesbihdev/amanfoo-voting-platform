<?php
// Your database connection and other necessary includes
require_once "./database/config.php";

// Step 1: Query the Position table to get the position name
$electionId = 1; // Replace 1 with the actual election_id
$positionId = 2; // Replace 2 with the actual position_id
$sqlPosition = "SELECT position_name FROM Positions WHERE election_id = :election_id AND position_id = :position_id";
$stmtPosition = $pdo->prepare($sqlPosition);
$stmtPosition->bindParam(':election_id', $electionId, PDO::PARAM_INT);
$stmtPosition->bindParam(':position_id', $positionId, PDO::PARAM_INT);
$stmtPosition->execute();
$position = $stmtPosition->fetch(PDO::FETCH_ASSOC);

// Step 2: Query to get candidate names and their votes for the specific position
$sqlCandidatesVotes = "SELECT candidate_name, votes_count FROM Candidates WHERE election_id = :election_id AND position_id = :position_id";
$stmtCandidatesVotes = $pdo->prepare($sqlCandidatesVotes);
$stmtCandidatesVotes->bindParam(':election_id', $electionId, PDO::PARAM_INT);
$stmtCandidatesVotes->bindParam(':position_id', $positionId, PDO::PARAM_INT);
$stmtCandidatesVotes->execute();
$candidatesData = $stmtCandidatesVotes->fetchAll(PDO::FETCH_ASSOC);
print_r($candidatesData);

?>

<!-- Your HTML code for displaying the chart goes here -->
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-chart-bar me-1"></i>
        <?php echo $position['position_name']; ?>
    </div>
    <div class="card-body">
        <canvas id="myBarChart" width="100%" height="50"></canvas>
    </div>
    <div class="card-footer small text-muted">
        Updated yesterday at 11:59 PM
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="js/scripts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>

<script>
    // Set new default font family and font color to mimic Bootstrap's default styling
    Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
    Chart.defaults.global.defaultFontColor = '#ffc107';

    // Bar Chart Example
    var ctx = document.getElementById("myBarChart");
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
                        maxTicksLimit: 6
                    }
                }],
                yAxes: [{
                    ticks: {
                        min: 0,
                        max: 100,
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