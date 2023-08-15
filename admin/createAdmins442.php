<?php
session_start();
//hidden line is here;

require_once "./database/config.php";
require_once "./auxilliaries.php";

require "./vendor/autoload.php";
$alert = "";

use FontLib\Table\Type\head;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

$mail = new PHPMailer(true);

// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

$mail->isSMTP();
$mail->isHTML(true);
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port = 587;



$mail->setFrom("no_reply@amanfoovoting.com", "AmanfooVoting");


if (isset($_POST['submit'])) {
  $subject = $_POST['subject'];
  $name = $_POST['name'];
  $adminId = $_POST['adminid'];
  $email = $_POST['email'];

  $mail->Subject = $subject;
  $mail->addAddress($email, $name);

  if (!empty($email) && !empty($name) && !empty($subject)) {

    // Insert the data into the Candidates table, including the file name
    $newAdmin = new Admin($pdo, 'admin');
    $admin = $newAdmin->read("email", $email);
    $numRows = count($admin); // Count the number of rows returned by the query
    $hashedAdminId = password_hash($adminId, PASSWORD_DEFAULT);
    if ($numRows == 0) {
      $data = [
        'admin_name' => $name,
        'email' => $email,
        'admin_id' => $hashedAdminId

      ];
      $message = '<!DOCTYPE html>
    <html>
    <head>
    <title>Amanfoo Voting Registration</title>
    </head>
    <body style="background-color: white; font-family: Arial, sans-serif; color: #333; font-size: larger">
    
    <table width="100%" border="0" cellspacing="0" cellpadding="20">
      <tr>
        <td align="center" style="background-color: green; padding: 20px; color: white;">
          <h1 style="margin: 0;">Amanfoo Dashboard Admin Details</h1>
        </td>
      </tr>
    </table>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="20">
      <tr>
        <td style="background-color: white; padding: 20px; border: 1px solid #ccc;">
          <p>Hello! <strong style="color: green;">' . $name . '</strong>,</p>
          <p>These are your admin login details:</p>
          <ul>
            <li><strong>Email:</strong> ' . $email . '</li>
            <li><strong>Admin ID (7-Digits):</strong> ' . $adminId . '</li>
          </ul>
        </td>
      </tr>
    </table>
    
    <table width="100%" border="0" cellspacing="0" cellpadding="20">
      <tr>
        <td align="center" style="background-color: yellow; padding: 20px; color: #333;">
          <p style="margin: 0;">Keep them very safe. Thank you.</p>
          <a href="https://linktr.ee/charlesbihdev"><small style="margin: 0; text-align: left">Developed By: Snr Charles Bih</small></a>
        </td>
      </tr>
    </table>
    </body>
    </html>';

      $mail->Body = $message;


      if ($newAdmin->create($data)) {
        // Display success message or redirect to a view voter ID page
        $alert = "showAlert('success', 'Candidate created successfully!')";

        //send mail
        if ($mail->send()) {
          $alert = "showAlert('success', 'Mail sent & Candidate created successfully!')";
          // echo "sent succesfully";
        } else {
          $alert = "showAlert('success', 'Candidate created successfully!')";
        }
      } else {
        // Display error message
        $alert = "showAlert('error', 'Error: Unable to create account.')";
      }
    } else {
      // Display error message
      $alert = "showAlert('error', 'Error: Email already exist.')";
      exit;
    }
  }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Amanfoo - Create User</title>
  <link href="./css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="./inc/sweetalert.js"> </script>
</head>

<body class="bg-info">
  <?php
  echo "<script>";
  echo $alert;
  echo "</script>";
  ?>
  <main>
    <div class="container">

      <div class="row justify-content-center">
        <div class="col-lg-5">
          <div class="card shadow-lg border-0 rounded-lg mt-5">
            <div class="card-header">
              <h3 class="text-center font-weight-light my-4 text-success">Send Custom Email</h3>
            </div>
            <div class="card-body">
              <form method="POST" action="">
                <div class="form-floating mb-3">
                  <input class="form-control" id="subject" name="subject" type="name" placeholder="Amanfoo Voting Admin Login Details" value="Amanfoo Voting Admin Login Details" required />
                  <label for="subject">Type your subject Here</label>
                </div>

                <div class="form-floating mb-3">
                  <input class="form-control" id="name" name="name" type="name" placeholder="Kofi Boakye" required />
                  <label for="name">Name of Reciever</label>
                </div>

                <div class="form-floating mb-3">
                  <input class="form-control" id="email" name="email" type="email" placeholder="name@example.com" required />
                  <label for="email">Destination Email address</label>
                </div>

                <div class="form-floating mb-3">
                  <input class="form-control" id="adminId" name="adminid" type="text" placeholder="Enter the admin Id" required />
                  <label for="adminId">Admin ID (7-digits) of Reciepient</label>
                </div>

                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                  <input type="submit" class="btn btn-warning" name="submit" value="Create User"></input>
                  <a href="./index.php">
                    <div class="btn btn-danger">Dashboard</div>
                  </a>

                </div>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
</body>

</html>
<?php
