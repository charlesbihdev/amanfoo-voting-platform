<?php
if (!isset($_GET['name'])) {
  echo "You visited an unauthorised Page";
  exit;
}
$name = $_GET['name'];
$email = $_GET['email'];
// $email
// $voterId 
$subject = "Your vote has been submitted successfully to the EC";


$message = '<!DOCTYPE html>
<html>
  <head>
    <title>Amanfoo Voting Success</title>
    <style>
      .container {
        max-width: 600px;
        margin: auto;
      }

      .thank-you-heading {
        color: #28a745;
        text-align: center;
        margin-bottom: 10px;
      }

      .thank-you-message {
        font-size: 20px;
        text-align: center;
        color: #343a40;
      }

      .dancing-toy {
        display: block;
        margin: 0 auto;
        max-width: 100%;
      }
    </style>
  </head>
  <body
    style="
      background-color: white;
      font-family: Arial, sans-serif;
      color: #333;
      font-size: larger;
    "
  >
    <table width="100%" border="0" cellspacing="0" cellpadding="20">
      <tr>
        <td
          align="center"
          style="background-color: green; padding: 10px; color: white"
        >
          <h1 style="margin: 0">Amanfoo Voting</h1>
        </td>
      </tr>
    </table>

    <table width="100%" border="0" cellspacing="0" cellpadding="20">
      <tr>
        <td
          style="background-color: white; padding: 20px; border: 1px solid #ccc"
        >
          <p>Hello! <strong style="color: green">' . $name . '</strong>,</p>
          <div class="container">
            <h1 class="thank-you-heading">Thank You Senior For Voting!</h1>
            <p class="thank-you-message">
              Your vote has been submitted successfully to the EC.
            </p>
            <img
              class="dancing-toy"
              src="https://i.imgur.com/DhTggCK.png"
              alt="Happys Dancing Toy"
              height="200px"
            />
          </div>
        </td>
      </tr>
    </table>

    <table width="100%" border="0" cellspacing="0" cellpadding="20">
      <tr>
        <td
          align="center"
          style="background-color: yellow; padding: 20px; color: #333"
        >
          <p style="margin: 0">Thank you for voting.</p>
          <a href="https://linktr.ee/charlesbihdev"
            ><small style="margin: 0; text-align: left"
              >Developed By: Snr Charles Bih</small
            ></a
          >
        </td>
      </tr>
    </table>
  </body>
</html>';



require "./admin/vendor/autoload.php";

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

// email and password here
$mail->Username = "bihcharles2004@gmail.com";
$mail->Password = "nbdevquibdacgftl";

$mail->setFrom("no_reply@amanfoovoting.com", "AmanfooVoting");

$mail->addAddress($email, $name);

$mail->Subject = $subject;
$mail->Body = $message;
if ($mail->send()) {
  $alert = "showAlert('success', 'Your details are sent to your inbox!')";

  // echo "sent succesfully";
} else {
  $alert = "showAlert('error', 'Error: Could'nt send your details to your inbox.')";
}
