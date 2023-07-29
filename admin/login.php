<?php
session_start();
require_once "./database/config.php";
require_once "./auxilliaries.php";

$alert = "";


if (isset($_POST['submit'])) {
    // Step 3: Get form data
    $adminId = $_POST['adminid'];
    $email = $_POST['email'];



    if (!empty($email) && !empty($adminId)) {
        // retrive data of user from db based on email
        $userToBeLogged = new Admin($pdo, 'admin');
        $results = $userToBeLogged->read("email", $email);
        //CHECK IF THE NUMBER OF ROW RETURNED IS > 0
        if (!empty($results)) {
            $retrievedEmail = $results[0]["email"];
            $retrievedAdminId = $results[0]["admin_id"];
            $retrievedId = $results[0]["id"];
            $AdminName = $results[0]["admin_name"];
            $isSuperAdmin = $results[0]["isSuperAdmin"];

            //CHECK IF USER EMAIL IS EQUAL TO RETRIEVED EMAIL AND USER PASSWORD IS EQUAL TO RETRIEVED PASSWORD
            if ($email == $retrievedEmail && $adminId == $retrievedAdminId) {
                //SESSION HERE
                $_SESSION['admin_id'] = $retrievedId;
                $_SESSION['admin_name'] = $AdminName;
                $_SESSION['isSuperAdmin'] = $isSuperAdmin;

                //REDIRECT USER TO VOTE PAGE
                header("location: ./index.php");
                exit();
            } else {
                //SHOW ERROR TO USER
                $alert = "showAlert('error', 'wrong email or voter ID')";
            }
        } else {
            //SHOW ERROR TO USER
            $alert = "showAlert('error', 'Account Not found')";
        }
    } else {
        // Display error message or redirect back to the form page with an error message
        $alert = "showAlert('error', 'Error: Please fill all required fields and upload a valid photo.')";
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
    <title>Login - Amanfoo Voting Platform</title>
    <link href="./css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./inc/sweetalert.js"> </script>
</head>

<body class="bg-success">
    <?php
    echo "<script>";
    echo $alert;
    echo "</script>";
    ?>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4 text-success">Login To Admin Dashboard</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="email" name="email" type="email" placeholder="name@example.com" required />
                                            <label for="email">Email address</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="voterid" name="adminid" type="name" placeholder="Enter your Voter Id" required />
                                            <label for="voterid">Admin Id</label>
                                        </div>
                                        <!-- <div class="form-check mb-3">
                                            <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                            <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                        </div> -->
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="password.php">Forgot Voter Id?</a>
                                            <input type="submit" class="btn btn-warning" name="submit" value="Login"></input>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Amanfoo Voting Platform 2023</div>
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
</body>

</html>