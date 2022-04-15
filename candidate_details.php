<?php
// db connection file
include 'db_conn.php';

// session check
require_once('check_login.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS | Candidate</title>

    <!-- style-sheet links -->
    <?php include 'style_links.php'; ?>
    <!-- /.style-sheet links -->

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <div style="font-size: xx-large;font-weight: bold;">Now Loading...</div>
        </div>

        <!-- Navbar -->
        <?php include 'navbar.php'; ?>
        <!-- /.navbar -->


        <!-- Sidebar -->
        <?php include 'sidebar.php' ?>
        <!-- /.sidebar -->


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">...</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">Candidates</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid p-3">
                    <div>
                        <button type="button" data-toggle="modal" data-target="#modal_insert" class="btn btn-outline-success" style="float:right">
                            <i class="fas fa-user-plus"></i> Add New

                        </button>

                        <h2>Candidate Details:</h2>
                    </div>
                    <br>
                    <?php

                    // fetching candidate data from db
                    $result = $conn->query("SELECT * FROM candidate_information");

                    if ($result->num_rows > 0) {
                        // displaying header for table view
                        echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Candidate ID" . "</th><th>" . "Full name" . "</th><th>" . "Date of Birth" . "</th><th>" . "Age" . "</th><th>" . "Gender" . "</th><th>" . "Address" . "</th><th>" . "Contact number" . "</th><th>" . "E-mail" . "</th><th colspan = '3'>" . "Actions" . "</th></tr>";

                        // displaying data from db
                        while ($row = $result->fetch_assoc()) {
                            $candidate_phone = $row["phnum"];
                            $candidate_email = $row["candidate_email"];
                            echo "<tr><td>" . $row["candidate_id"] . "</td><td id = 'fname_td'>" . $row["candidate_fullname"] . "</td><td id = 'dob_td'>" . $row["candidate_dob"] . "</td><td id = 'age_td'>" . $row["candidate_age"] . "</td><td id = 'gender_td'>" . $row["candidate_gender"] . "</td><td id = 'address_td'>" . $row["candidate_address"] . "</td><td id = 'phnum_td'> <a href='tel:$candidate_phone' class='hyperlinked_phones'>$candidate_phone</a></td><td id = 'email_td'><a href='mailto:$candidate_email' class='hyperlinked_emails'>$candidate_email</a></td>";
                    ?>
                            <td><a href="candidate_delete.php?del=<?php echo $row["candidate_id"]; ?>"><button type="submit" class="btn btn-danger">Delete</button></td>
                            <?php
                            // different button styles based on whether candidate was already accepted or not
                            if ($row["employee_id"]) {
                                echo "<td><button type='submit' class='btn btn-warning' disabled>Cannot update</button></td>";
                                echo "<td><button type='submit' class='btn btn-secondary' disabled>Accepted</button></td></tr>";
                            } else {
                            ?>
                                <td><button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal_update<?php echo $row["candidate_id"]; ?>">Update</button></td>
                                <td><a href='emp_info.php?acc=<?php echo $row["candidate_id"]; ?>'><button type='submit' class='btn btn-success'>Accept</button></td>
                                </tr>
                    <?php
                            }
                            include 'candidate_upd.php';
                        }
                        echo "</table>";
                    } else {
                        echo " <div class='empty-state'>
                       <div class='empty-state__content'>
                       <div class='empty-state__icon'>
                       <i class='fa-solid fa-id-card'></i>
                       </div>
                       <div class='empty-state__message'>No Candidate data</div>
                       <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span>
                       Add Candidates by clicking Add New.
                       </div>
                       </div>
                       </div>";
                    }

                    // closing connection
                    $conn->close();
                    ?>

                    <!-- Modal -->
                    <div class="modal fade" id="modal_insert" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Candidate form: </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container p-5 my-2 border">
                                        <h2>Enter your details here:</h2><br>
                                        <form name="candidate_info" action="candidate_insert.php" method="POST">

                                            <div class="form-group">
                                                <label for="fullname" class="form-label">Full Name: </label>
                                                <input type="text" class="form-control" id="fname" name="fullname" required>
                                            </div>
                                            <br>

                                            <div class="form-inline">
                                                <label for="dob" class="form-label">Date of Birth: </label>
                                                <div class="col-sm-2">
                                                    <input type="date" class="form-control" id="dob" name="dateofbirth" required>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-check">
                                                <label for="gender" class="form-label">Gender: </label>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="gender" name="gender" value="Male" checked>Male
                                                    <label class="form-check-label" for="radio1"></label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="gender" name="gender" value="Female">Female
                                                    <label class="form-check-label" for="radio1"></label>
                                                </div>
                                                <div class="form-check">
                                                    <input type="radio" class="form-check-input" id="gender" name="gender" value="Others">Others
                                                    <label class="form-check-label" for="radio1"></label>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label for="address" class="form-label">Address: </label>
                                                <textarea type="text" class="form-control" rows="5" cols="33" id="address" name="address" required></textarea>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label for="email" class="form-label">Email address: </label>
                                                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
                                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label for="phnum" class="form-label">Phone number: (+91) </label>
                                                <input type="tel" class="form-control" id="phnum" name="phnumber" maxlength="10" pattern="[1-9]{1}[0-9]{9}" title="Please enter a valid 10 digits contact number" required>
                                            </div>
                                            <br>

                                            <div class="form-inline">
                                                <label for="workexp" class="form-label">Experience (in years): </label>
                                                <div class="col-sm-2">
                                                    <input type="number" class="form-control" id="workexp" name="workexperience" required>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label for="qualif" class="form-label">Qualifications: </label>
                                                <input type="text" class="form-control" id="qualif" name="qualifications" required>
                                            </div>
                                            <br>

                                            <button type="submit" class="btn btn-primary" style="float: right;">Submit</button>

                                        </form>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.Modal -->

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
            <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top" style="opacity: 60%;">
                <i class="fas fa-chevron-up"></i>
            </a>
            <!-- /.back-to-top button -->
        </div>
        <!-- /.content-wrapper -->
        <!-- footer -->
        <?php include 'footer.php'; ?>
        <!-- /.footer -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- scripts -->
    <?php include 'scripts.php'; ?>
    <!-- /.scripts -->
</body>

</html>