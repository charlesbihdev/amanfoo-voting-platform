<?php
require_once "./admin/database/config.php";
require_once "./admin/auxilliaries.php";

if (isset($_GET['voterid'])) {
    $voterId = $_GET['voterid'];
    $email = $_GET['email'];
    $name = $_GET['name'];
} else {
    header("location: ./register.php");
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
    <title>Voting - Registration</title>
    <link href="./admin/css/styles.css" rel="stylesheet" />
    <link rel="shortcut icon" href="./assets/img/favicon-32x32.png" type="image/x-icon">
    <link rel="stylesheet" href="./admin/inc/style.css" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="./admin/inc/sweetalert.js"> </script>
</head>

<body class="bg-success">
    <?php
    echo "<script>";
    echo $alert;
    echo "</script>";
    ?>
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content" class="mb-4">
            <main>
                <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel">Login Page Confirmation</h4>
                            </div>
                            <div class="modal-body">
                                <p>Have you written your voters ID down?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                <a class="btn btn-success btn-ok">Yes, I have</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4 text-success">Keep Your Voter ID Safe</h3>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="" enctype="multipart/form-data">

                                        <div class="row mb-3">

                                            <div class="col-md mx-auto">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input style="font-size: larger; font-weight: bolder;" class="form-control text-center " id="inputPasswordConfirm" type="text" value="<?php echo $voterId ?>" readonly />
                                                    <label for="uniqueVoterId">Your Unique Voter ID (7 digits)</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid">
                                                <a href="#" data-href="./" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#confirm-delete">Registration Succesfull. You can exit;</a>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class=" text-danger">Please write it down or screenshot before you proceed</div>
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
                            <a href="https://linktr.ee/charlesbihdev"><small style="margin: 0; text-align: left">Developed By: Snr Charles Bih</small></a>

                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <?php require_once "./send_register_emails.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="./admin/js/scripts.js"></script>
    <?php require_once "./admin/inc/footer.php"; ?>

</body>

</html>