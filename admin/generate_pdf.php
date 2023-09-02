<?php
session_start();

if (!isset($_SESSION['admin_id']) || !isset($_SESSION['isSuperAdmin']) || !isset($_SESSION['admin_name'])) {
   // User is not logged in or missing required parameters
   echo "You visited an unauthorized page";
   exit;
}

require_once "./database/config.php";
require_once "./auxilliaries.php";
require __DIR__ . "/vendor/autoload.php";

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options;
$options->setChroot(__DIR__);

// Create a new PDF document
$dompdf = new Dompdf($options);

// Set document properties
$dompdf->setPaper('A4', 'portrait');
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isRemoteEnabled', true); // Enable loading remote images

if (isset($_POST['range'])) {
   $range = explode('-', $_POST['range']);
   $start = (int)$range[0];
   $end = (int)$range[1];
} else {
   // Default to exporting all voters if no range is selected
   $start = 1;
   $end = PHP_INT_MAX; // Set a large number to fetch all voters
}

$electionId = isset($_GET['electionid']) ? $_GET['electionid'] : null;

// Fetch voters' data for the selected range
$sqlVoters = "SELECT u.*, COUNT(v.vote_id) AS vote_count
              FROM users u
              LEFT JOIN votes v ON u.user_id = v.user_id
              WHERE u.election_id = :election_id
              GROUP BY u.user_id
              ORDER BY u.year
              LIMIT :start, :end";

$stmtVoters = $pdo->prepare($sqlVoters);
$stmtVoters->bindValue(':election_id', $electionId, PDO::PARAM_INT);
$stmtVoters->bindValue(':start', $start - 1, PDO::PARAM_INT); // Subtract 1 because SQL LIMIT starts from 0
$stmtVoters->bindValue(':end', $end - $start + 1, PDO::PARAM_INT); // Calculate the number of rows to fetch
$stmtVoters->execute();
$voters = $stmtVoters->fetchAll(PDO::FETCH_ASSOC);

// Generate the PDF content
$html = '<html><head><style>
         body {
            text-align: center;
         }
         h1 {
            color: green;
         }
         table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
         }
         th, td {
            border: 1px solid #000;
            padding: 2px;
            text-align: center;
         }
         img {
            width: 120px;
         }
         </style></head><body>';
$html .= '<h1>Registered Voters List</h1>';
$html .= '<table>
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Year Group</th>
                    <th>House</th>
                </tr>
            </thead>
            <tbody>';

$sn = $start;
foreach ($voters as $voter) {
   $imagesrc = $voter['photo'];
   $imagePath = './assets/uploads/' . $imagesrc;
   $html .= '<tr>
               <td>' . $sn++ . '</td>
               <td><img src="' . $imagePath . '"></td>
               <td>' . $voter['name'] . '</td>
               <td>' . $voter['year'] . '</td>
               <td>' . $voter['house'] . '</td>
           </tr>';
}

$html .= '</tbody></table>';
$html .= '</body></html>';

$dompdf->loadHtml($html);

// Render the PDF (first parameter is the output mode: 'stream' or 'download')
$dompdf->render();

// Output the PDF to the browser
$dompdf->stream('voters_list.pdf', array('Attachment' => false));
