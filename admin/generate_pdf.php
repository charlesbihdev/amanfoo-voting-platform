<?php
session_start();

if (!isset($_SESSION['admin_id']) || !isset($_SESSION['isSuperAdmin']) || !isset($_GET['electionid']) || !isset($_SESSION['admin_name'])) {
   // User is logged in
   echo "you visited an unauthorized page";
   exit;
}

$electionId = $_GET['electionid'];
require_once "./database/config.php";
require_once "./auxilliaries.php";
require __DIR__ . "/vendor/autoload.php";

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

use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options;
$options->setChroot(__DIR__);
// Create new PDF document
$dompdf = new Dompdf($options);

// Set document properties
$dompdf->setPaper('A4', 'portrait');
$dompdf->set_option('isHtml5ParserEnabled', true);
$dompdf->set_option('isRemoteEnabled', true); // Enable loading remote images


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
// $html .= '<img src="./assets/uploads/image_64bd36de8cef0.jpg" height="180" width="170px">';

$html .= '<table>
            <thead>
                <tr>
                    <th>S/N</th>
                    <th>Photo</th>
                    <th>Name</th>
                    <th>Year Group</th>
                </tr>
            </thead>
            <tbody>';

$sn = 1;
// foreach ($voters as $voter) {
//    $html .= '<tr>
//                 <td>' . $sn++ . '</td>
//                 <td><img src="./assets/uploads/' . $voter['name'] . '"></td>
//                 <td>' . $voter['name'] . '</td>
//                 <td>' . $voter['year'] . '</td>
//             </tr>';
// }
foreach ($voters as $voter) {
   $imagesrc = $voter['photo'];
   $imagePath = './assets/uploads/' . $imagesrc;
   $html .= '<tr>
               <td>' . $sn++ . '</td>
               <td><img src="' . $imagePath . '"></td>
               <td>' . $voter['name'] . '</td>
               <td>' . $voter['year'] . '</td>
           </tr>';
}

$html .= '</tbody></table>';
$html .= '</body></html>';

$dompdf->loadHtml($html);

// Render the PDF (first parameter is the output mode: 'stream' or 'download')
$dompdf->render();

// Output the PDF to the browser
$dompdf->stream('voters_list.pdf', array('Attachment' => false));
