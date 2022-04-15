<?php
// db connection file
include 'db_conn.php';

// session check
require_once('check_login.php');

$count = $_GET["c"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HRMS | History</title>

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
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                <li class="breadcrumb-item active">History Records</li>
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
                        <h2>History Records: </h2>
                    </div>
                    <br>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="hisTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 0) echo "active"; ?>" id="HisJob-tab" data-toggle="tab" href="#HisJob" role="tab" aria-controls="HisJob" aria-selected="<?php if ($count == 0) echo "true";
                                                                                                                                                                                            else echo "false"; ?>">Job History</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 1) echo "active"; ?>" id="Hisdisc-tab" data-toggle="tab" href="#HisDisc" role="tab" aria-controls="HisDisc" aria-selected="<?php if ($count == 1) echo "true";
                                                                                                                                                                                                else echo "false"; ?>">Disciplinary History</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 2) echo "active"; ?>" id="Hissal-tab" data-toggle="tab" href="#Hissal" role="tab" aria-controls="Hissal" aria-selected="<?php if ($count == 2) echo "true";
                                                                                                                                                                                            else echo "false"; ?>">Salary History</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 3) echo "active"; ?>" id="HisOtp-tab" data-toggle="tab" href="#HisOtp" role="tab" aria-controls="HisOtp" aria-selected="<?php if ($count == 3) echo "true";
                                                                                                                                                                                            else echo "false"; ?>">Overtime Pay History</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- jobHistory -->
                        <div class="tab-pane fade <?php if ($count == 0) echo "show active"; ?>" id="HisJob" role="tabpanel" aria-labelledby="HisJob-tab">
                            <button type="button" data-toggle="modal" data-target="#modal_insert_HisJob" class="btn btn-outline-success" style="float:right">
                                <i class="fas fa-plus"></i> Add New

                            </button>
                            <br><br>

                            <?php

                            // retrieves all job History information records
                            $result = $conn->query("SELECT * FROM job_history group by employee_id desc");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Employee ID" . "</th><th>" . "Employee" . "</th><th>" . "Designation" . "</th><th>" . "Start Date" . "</th><th>" . "Action" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {

                                    $res = mysqli_query($conn, "select * from employee_information where employee_id = '$row[employee_id]'");
                                    $emprow = $res->fetch_assoc();
                                    $res = mysqli_query($conn, "select * from designations where designation_id = '$row[designation_id]'");
                                    $desrow = $res->fetch_assoc();

                                    echo "<tr><td>" . $emprow["employee_id"] . "</td><td>" . $emprow["employee_name"] . "</td><td>" . $desrow["designation"] . "</td><td>" . $row["job_start_date"] . "</td>";

                            ?>
                                    <td><button data-id="<?php echo $row["employee_id"]; ?>" class="btn btn-info userinfo">View</button></td>
                                    </tr>
                            <?php
                                }

                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-solid fa-clock-rotate-left'></i>
                               </div>
                               <div class='empty-state__message'>No History data</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span>
                               Set employee designations in Designations tab under Compny Structure tab Or Add New.
                               </div>
                               </div>
                               </div>";
                            }

                            ?>

                        </div><!-- /.jobHistory -->

                        <!-- disciplinary -->
                        <div class="tab-pane fade <?php if ($count == 1) echo "show active"; ?>" id="HisDisc" role="tabpanel" aria-labelledby="Hisdisc-tab">
                            <button type="button" data-toggle="modal" data-target="#modal_insert_HisDisc" class="btn btn-outline-success" style="float:right">
                                <i class="fas fa-plus"></i> Add New

                            </button>
                            <br><br>
                            <?php

                            // retrieves all disciplinary history information records
                            $result = $conn->query("SELECT * FROM disciplinary_history group by employee_id order by history_id desc");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Employee ID" . "</th><th>" . "Employee" . "</th><th>" . "Behaviour Standard" . "</th><th>" . "Disciplinary Action" . "</th><th>" . "Date" .  "</th><th>" . "Action" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {

                                    $res = mysqli_query($conn, "select * from employee_information where employee_id = '$row[employee_id]'");
                                    $emprow = $res->fetch_assoc();

                                    echo "<tr><td>" . $emprow["employee_id"] . "</td><td>" . $emprow["employee_name"] . "</td><td>" . $row["behaviour_standard"] . "</td><td>" . $row["disciplinary_action"] . "</td><td>" . $row["dis_date"] . "</td>";

                            ?>
                                    <td><button data-id="<?php echo $row["employee_id"]; ?>" class="btn btn-info HisDiscinfo">View</button></td>
                                    </tr>

                            <?php

                                }

                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-solid fa-clock-rotate-left'></i>
                               </div>
                               <div class='empty-state__message'>No History data</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span>
                               Add New Disciplinary record by clicking the button Add New.
                               </div>
                               </div>
                               </div>";
                            }


                            ?>
                        </div><!-- /.disciplinary -->

                        <!-- Salary Hsitory -->
                        <div class="tab-pane fade <?php if ($count == 2) echo "show active"; ?>" id="Hissal" role="tabpanel" aria-labelledby="Hissal-tab">
                            <?php

                            // retrieves all salary records
                            $result = $conn->query("SELECT * FROM employee_salary where clearance='cleared' group by employee_id desc");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Employee ID" . "</th><th>" . "Employee" . "</th><th>" . "Amount (Rs.)" . "</th><th>" . "Date" . "</th><th>" . "Clearance" . "</th><th>" . "Action" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {

                                    $emprow = mysqli_query($conn, "select * from employee_information where employee_id = '$row[employee_id]'");
                                    $emprow = $emprow->fetch_assoc();

                                    echo "<tr><td>" . $emprow["employee_id"] . "</td><td>" . $emprow["employee_name"] . "</td><td>" . $row["salary_amount"] . "</td><td>" . $row["salary_date"] . "</td><td>" . $row["clearance"] . "</td>";
                            ?>


                                    <td><button data-id="<?php echo $row["employee_id"]; ?>" class="btn btn-info salhisinfo">View</button></td>
                                    </tr>
                            <?php
                                }

                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-solid fa-clock-rotate-left'></i>
                               </div>
                               <div class='empty-state__message'>No History data</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span>
                               Clear salaries in Salary Payments tab under Financial records tab.
                               </div>
                               </div>
                               </div>";
                            }


                            ?>
                        </div>
                        <!-- /.Salary Hsitory -->

                        <!-- Overtime Pay Hsitory -->
                        <div class="tab-pane fade <?php if ($count == 3) echo "show active"; ?>" id="HisOtp" role="tabpanel" aria-labelledby="HisOtp-tab">
                            <?php

                            // retrieves all cleared overtime payment records
                            $result = $conn->query("SELECT * FROM overtime_pay_emp where clearance='cleared' group by employee_id desc");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Employee ID" . "</th><th>" . "Employee" . "</th><th>" . "Date" .  "</th><th>" . "Hours Worked" . "</th><th>" . "Amount(Rs.)" . "</th><th>" . "Clearance" . "</th></tr>";

                                // displaying data along with adding button for view
                                while ($row = $result->fetch_assoc()) {

                                    // fetches employee information
                                    $emprow = mysqli_query($conn, "select * from employee_information where employee_id = '$row[employee_id]'");
                                    $emprow = $emprow->fetch_assoc();

                                    echo "<tr><td>" . $emprow["employee_id"] . "</td><td>" . $emprow["employee_name"] . "</td><td>" . $row["otp_date"] . "</td><td>" . $row["hrs_worked"] .  "</td><td>" . $row["total_amt"] . "</td><td>" . $row["clearance"] . "</td>";
                            ?>
                                    <td><button data-id="<?php echo $row["employee_id"]; ?>" class="btn btn-info otphisinfo">View</button></td>
                                    </tr>
                            <?php
                                }

                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-solid fa-clock-rotate-left'></i>
                               </div>
                               <div class='empty-state__message'>No History data</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span>
                               Clear Overtime in Overtime Payments tab under Financial records tab.
                               </div>
                               </div>
                               </div>";
                            }

                            ?>
                        </div><!-- /.Salary Hsitory -->

                    </div><!-- /.Tab-panes -->

                    <!-- Modal-HisJob Insert -->
                    <div class="modal fade" id="modal_insert_HisJob" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="overflow:hidden;">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Job History form: </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container p-5 my-2 border">
                                        <h2>Enter Job History Record:</h2><br>
                                        <form name="HisJob_form" action="HisJob_insert.php" method="POST">

                                            <div class="form-group">
                                                <label for="ename" class="form-label">Select Employee: </label>
                                                <select id="ename" class="form-control select2bs4" name="ename" style="width: 100%;" required>
                                                    <?php
                                                    // retrieving all employee_information
                                                    $result = $conn->query("select * from employee_information");

                                                    while ($row = $result->fetch_assoc()) {
                                                        // displaying each employee_information in the list
                                                        echo "<option value = '$row[employee_id]'>" . $row["employee_name"] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div><br>

                                            <div class="form-inline">
                                                <label for="start" class="form-label">Start Date : </label>
                                                <div class="col-sm-2">
                                                    <input type="date" class="form-control" id="start" name="start" required>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label for="dname" class="form-label">Select Designation: </label>
                                                <select id="dname" class="form-control select2bs4" name="dname" style="width: 100%;" required>
                                                    <?php
                                                    // retrieving all Designation
                                                    $result = $conn->query("select * from designations");

                                                    while ($row = $result->fetch_assoc()) {
                                                        // displaying each Designation in the list
                                                        echo "<option value = '$row[designation_id]'>" . $row["designation"] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div><br>

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

                    <!-- Modal-HisDisc Insert -->
                    <div class="modal fade" id="modal_insert_HisDisc" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="overflow:hidden;">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Disciplinary History form: </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container p-5 my-2 border">
                                        <h2>Enter Disciplinary History Record:</h2><br>
                                        <form name="HisJob_form" action="HisDisc_insert.php" method="POST">

                                            <div class="form-group">
                                                <label for="empname" class="form-label">Select Employee: </label>
                                                <select id="empname" class="form-control select2bs4" name="empname" style="width: 100%;" required>
                                                    <?php
                                                    // retrieving all employee_information
                                                    $result = $conn->query("select * from employee_information");

                                                    while ($row = $result->fetch_assoc()) {
                                                        // displaying each employee_information in the list
                                                        echo "<option value = '$row[employee_id]'>" . $row["employee_name"] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div><br>

                                            <div class="form-inline">
                                                <label for="date" class="form-label">Date : </label>
                                                <div class="col-sm-2">
                                                    <input type="date" class="form-control" id="date" name="date" required>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label for="best" class="form-label">Behaviour standard: </label>
                                                <textarea type="text" class="form-control" rows="5" cols="33" id="best" name="best" required></textarea>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label for="disc" class="form-label">Disciplinary action ▲: </label>
                                                <textarea type="text" class="form-control" rows="5" cols="33" id="disc" name="disc" required></textarea>
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

                    <!-- Modal HisJob View -->
                    <div class="modal fade" id="modal_view_HisJob" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="overflow:hidden;">
                        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Job History:</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                                </div>
                                <div id="modal-body-hisJob" class="modal-body">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.Modal -->

                    <!-- Modal salhis View -->
                    <div class="modal fade" id="modal_view_Hissal" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="overflow:hidden;">
                        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Salary History:</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                                </div>
                                <div id="modal-body-hissal" class="modal-body">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.Modal -->

                    <!-- Modal HisOtp View -->
                    <div class="modal fade" id="modal_view_HisOtp" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="overflow:hidden;">
                        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Overtime Pay History:</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                                </div>
                                <div id="modal-body-HisOtp" class="modal-body">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.Modal -->

                    <!-- Modal HisDiscinfo View -->
                    <div class="modal fade" id="modal_view_HisDisc" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="overflow:hidden;">
                        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Disciplinary History:</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                                </div>
                                <div id="modal-body-HisDisc" class="modal-body">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.Modal -->

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
    <script type='text/javascript'>
        $(document).ready(function() {

            $('.userinfo').click(function() {

                var userid = $(this).data('id');

                // AJAX request
                $.ajax({
                    url: 'ajax_hisJob.php',
                    type: 'post',
                    data: {
                        userid: userid
                    },
                    success: function(response) {
                        // Add response in Modal body
                        $('#modal-body-hisJob').html(response);

                        // Display Modal
                        $('#modal_view_HisJob').modal('show');
                    }
                });
            });
        });

        $(document).ready(function() {

            $('.salhisinfo').click(function() {

                var userid = $(this).data('id');

                // AJAX request
                $.ajax({
                    url: 'ajax_hissal.php',
                    type: 'post',
                    data: {
                        userid: userid
                    },
                    success: function(response) {
                        // Add response in Modal body
                        $('#modal-body-hissal').html(response);

                        // Display Modal
                        $('#modal_view_Hissal').modal('show');
                    }
                });
            });
        });

        $(document).ready(function() {

            $('.otphisinfo').click(function() {

                var userid = $(this).data('id');

                // AJAX request
                $.ajax({
                    url: 'ajax_HisOtp.php',
                    type: 'post',
                    data: {
                        userid: userid
                    },
                    success: function(response) {
                        // Add response in Modal body
                        $('#modal-body-HisOtp').html(response);

                        // Display Modal
                        $('#modal_view_HisOtp').modal('show');
                    }
                });
            });
        });

        $(document).ready(function() {

            $('.HisDiscinfo').click(function() {

                var userid = $(this).data('id');

                // AJAX request
                $.ajax({
                    url: 'ajax_HisDisc.php',
                    type: 'post',
                    data: {
                        userid: userid
                    },
                    success: function(response) {
                        // Add response in Modal body
                        $('#modal-body-HisDisc').html(response);

                        // Display Modal
                        $('#modal_view_HisDisc').modal('show');
                    }
                });
            });
        });
    </script>
    <!-- /.scripts -->
</body>

</html>