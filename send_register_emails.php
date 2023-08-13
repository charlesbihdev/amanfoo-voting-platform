<?php
if (!isset($email) || !isset($name) || !isset($voterId)) {
  echo "You visited an unauthorised Page";
  exit;
}
//$name
// $email
// $voterId 
$subject = "Amanfoo Voting Login Details";

$message = '<!DOCTYPE html>
<html>
<head>
<title>Amanfoo Voting Registration</title>
</head>
<body style="background-color: white; font-family: Arial, sans-serif; color: #333; font-size: larger">

<table width="100%" border="0" cellspacing="0" cellpadding="20">
  <tr>
    <td align="center" style="background-color: green; padding: 20px; color: white;">
      <h1 style="margin: 0;">Amanfoo Voting Registration</h1>
    </td>
  </tr>
</table>

<table width="100%" border="0" cellspacing="0" cellpadding="20">
  <tr>
    <td style="background-color: white; padding: 20px; border: 1px solid #ccc;">
      <p>Hello! <strong style="color: green;">' . $name . '</strong>,</p>
      <p>These are your login details:</p>
      <ul>
        <li><strong>Email:</strong> ' . $email . '</li>
        <li><strong>Voter ID (7-Digits):</strong> ' . $voterId . '</li>
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

$mail->Username = "bihcharles2004@gmail.com";
$mail->Password = "nbdevquibdacgftl";

$mail->setFrom("no_reply@amanfoovoting.com", "AmanfooVoting");

$mail->addAddress($email, $name);

$mail->Subject = $subject;
$mail->Body = $message;
if ($mail->send()) {
  echo "sent succesfully";
} else {
  echo "unable to send";
}
