<?php

$electionId = 1;
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
<h1>jiii</h1>

<?php foreach ($voters as $index => $voter) { ?>
<?php } ?>

<td><?php echo $voter['vote_count'] > 0 ? 'Yes' : 'No'; ?></td>