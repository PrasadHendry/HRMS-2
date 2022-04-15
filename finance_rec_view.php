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
    <title>HRMS | Finance</title>

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
                                <li class="breadcrumb-item active">Finance</li>
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
                        <h2>Finance Records: </h2>
                    </div>
                    <br>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="finTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 0) echo "active"; ?>" id="Sal-tab" data-toggle="tab" href="#Sal" role="tab" aria-controls="Sal" aria-selected="<?php if ($count == 0) echo "true";
                                                                                                                                                                                    else echo "false"; ?>">Salary Payments &nbsp;
                                <?php
                                // retrieving number of employees without designations
                                $result = mysqli_query($conn, "select count(salary_id) from employee_salary where clearance = 'pending'");
                                $row = $result->fetch_assoc();

                                // if there is atleast one employee without a designation, shows a count of employees without designations
                                if ($row["count(salary_id)"] > 0)
                                    echo "<span data-toggle='tooltip' data-placement='top' title='△ Pending salary clearance △' class='badge badge-warning right'>" . $row["count(salary_id)"] . "</span>";
                                ?>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 1) echo "active"; ?>" id="Otp-tab" data-toggle="tab" href="#Otp" role="tab" aria-controls="Otp" aria-selected="<?php if ($count == 1) echo "true";
                                                                                                                                                                                    else echo "false"; ?>">Overtime Payments &nbsp;
                                <?php
                                // retrieving number of employees without designations
                                $result = mysqli_query($conn, "select count(otp_pay_id) from overtime_pay_emp where clearance = 'pending'");
                                $row = $result->fetch_assoc();

                                // if there is atleast one employee without a designation, shows a count of employees without designations
                                if ($row["count(otp_pay_id)"] > 0)
                                    echo "<span data-toggle='tooltip' data-placement='top' title='△ Pending Overtime Pay clearance △' class='badge badge-warning right'>" . $row["count(otp_pay_id)"] . "</span>";
                                ?>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 2) echo "active"; ?>" id="Comp-tab" data-toggle="tab" href="#Comp" role="tab" aria-controls="Comp" aria-selected="<?php if ($count == 2) echo "true";
                                                                                                                                                                                        else echo "false"; ?>">Compensation</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- Salary -->
                        <div class="tab-pane fade <?php if ($count == 0) echo "show active"; ?>" id="Sal" role="tabpanel" aria-labelledby="Sal-tab">
                            <br>
                            <a href="emp_clear_all.php"><button type="button" class="btn btn-warning" style="float:left; border-radius: 25px;">
                                    <i class="fas fa-coins"></i> Clear All

                                </button></a>
                            <a href="emp_add_sal.php"><button type="button" class="btn btn-outline-success" style="float:right;">
                                    <i class="fas fa-wallet"></i> Add New

                                </button></a>
                            <br><br>
                            <?php

                            // retrieves all salary records
                            $result = $conn->query("SELECT * FROM employee_salary where clearance = 'pending' order by employee_id, salary_id desc");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Employee ID" . "</th><th>" . "Employee" . "</th><th>" . "Amount (Rs.)" . "</th><th>" . "Date" . "</th><th>" . "Clearance" . "</th><th colspan = '2'>" . "Actions" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {

                                    $emprow = mysqli_query($conn, "select * from employee_information where employee_id = '$row[employee_id]'");
                                    $emprow = $emprow->fetch_assoc();

                                    echo "<tr><td>" . $emprow["employee_id"] . "</td><td>" . $emprow["employee_name"] . "</td><td>" . $row["salary_amount"] . "</td><td>" . $row["salary_date"] . "</td><td>" . $row["clearance"] . "</td>";

                                    if ($row["clearance"] == "cleared") {
                                        echo "<td><button type='submit' class='btn btn-secondary' disabled>Cleared</button></td></tr>";
                                    } else {
                            ?>
                                        <td><button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal_edit_sal<?php echo $row["salary_id"]; ?>">Edit</button></td>
                                        <td><a href='emp_sal_clear.php?clr=<?php echo $row["salary_id"]; ?>'><button type='submit' class='btn btn-success'>Clear</button></a></td>
                                        </tr>
                            <?php
                                    }
                                    include 'emp_sal_upd.php';
                                }

                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-solid fa-indian-rupee-sign'></i>
                               </div>
                               <div class='empty-state__message'>All Past Salary Payments are Cleared</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span>
                               Add new payments by clicking the button Add New.
                               </div>
                               </div>
                               </div>";
                            }

                            ?>
                        </div><!-- /.Salary -->

                        <!-- Overtime Pay -->
                        <div class="tab-pane fade <?php if ($count == 1) echo "show active"; ?>" id="Otp" role="tabpanel" aria-labelledby="Otp-tab">
                            <br>
                            <p>These are Overtime Pay records:</p>
                            <br>
                            <?php

                            // retrieves all overtime_pay_emp records
                            $result = $conn->query("SELECT * FROM overtime_pay_emp where clearance = 'pending' group by employee_id order by otp_pay_id  desc");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Employee ID" . "</th><th>" . "Employee" . "</th><th>" . "Date" .  "</th><th>" . "Total Hours-Worked" . "</th><th>" . "Total amount(Rs.)" . "</th><th>" . "Clearance" . "</th><th colspan = '2'>" . "Actions" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {

                                    // fetches employee information
                                    $emprow = mysqli_query($conn, "select * from employee_information where employee_id = '$row[employee_id]'");
                                    $emprow = $emprow->fetch_assoc();

                                    // for the sum of all uncleared records for a specific employee
                                    $empamt = mysqli_query($conn, "select sum(hrs_worked) as hrs_worked, sum(total_amt) as total_amt from overtime_pay_emp where employee_id = '$row[employee_id]'");
                                    $empamt = $empamt->fetch_assoc();

                                    echo "<tr><td>" . $emprow["employee_id"] . "</td><td>" . $emprow["employee_name"] . "</td><td>" . $row["otp_date"] . "</td><td>" . $empamt["hrs_worked"] .  "</td><td>" . $empamt["total_amt"] . "</td><td>" . $row["clearance"] . "</td>";
                            ?>
                                    <td><a href='otp_emp_clear.php?clr=<?php echo $row["employee_id"]; ?>'><button type='submit' class='btn btn-success'>Clear All</button></a></td>
                                    <td><button data-id="<?php echo $row["employee_id"]; ?>" class="btn btn-info otppayinfo">View</button></td>
                                    </tr>
                            <?php
                                }

                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-solid fa-indian-rupee-sign'></i>
                               </div>
                               <div class='empty-state__message'>All Past Overtime Payments are Cleared</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span><br>
                               Overtime Payments will be shown if the employee has done overtime during his shift.
                               <br>Check Attentance records in Time and Attendance tab.
                               </div>
                               </div>
                               </div>";
                            }

                            ?>
                        </div><!-- /.Overtime Pay  -->

                        <!-- Compensation -->
                        <div class="tab-pane fade <?php if ($count == 2) echo "show active"; ?>" id="Comp" role="tabpanel" aria-labelledby="Comp-tab">
                            <button type="button" data-toggle="modal" data-target="#modal_insert_comp" class="btn btn-outline-success" style="float:right">
                                <i class="fas fa-file-invoice"></i>&nbsp; Add New

                            </button>
                            <br><br>
                            <?php

                            // retrieves all cleared compensation records
                            $result = $conn->query("SELECT * FROM compensation where clearance = 'pending' order by compensation_id desc");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Employee ID" . "</th><th>" . "Employee" . "</th><th>" . "Type" . "</th><th>" . "Description" . "</th><th>" . "Amount" . "</th><th>" . "Date" . "</th><th>" . "Clearance" . "</th><th>" . "Clear" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {

                                    $emprow = mysqli_query($conn, "select * from employee_information where employee_id = '$row[employee_id]'");
                                    $emprow = $emprow->fetch_assoc();

                                    echo "<tr><td>" . $emprow["employee_id"] . "</td><td>" . $emprow["employee_name"] . "</td><td>" . $row["compensation_type"] . "</td><td>" . $row["compensation_description"] . "</td><td>" . $row["compensation_amt"] . "</td><td>" . $row["cmp_Date"] . "</td><td>" . $row["clearance"] . "</td>";
                            ?>
                                    <td><a href='comp_clear.php?acc=<?php echo $row["compensation_id"]; ?>'><button type='submit' class='btn btn-success'>Clear</button></td>
                                    </tr>
                            <?php
                                }

                                echo "</table>";
                            }

                            // retrieves all cleared compensation records
                            $result = $conn->query("SELECT * FROM compensation where clearance = 'cleared' group by employee_id order by compensation_id desc");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Employee ID" . "</th><th>" . "Employee" . "</th><th>" . "Type" . "</th><th>" . "Description" . "</th><th>" . "Amount" . "</th><th>" . "Date" . "</th><th>" . "Clearance" . "</th><th>" . "View" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {

                                    $emprow = mysqli_query($conn, "select * from employee_information where employee_id = '$row[employee_id]'");
                                    $emprow = $emprow->fetch_assoc();

                                    echo "<tr><td>" . $emprow["employee_id"] . "</td><td>" . $emprow["employee_name"] . "</td><td>" . $row["compensation_type"] . "</td><td>" . $row["compensation_description"] . "</td><td>" . $row["compensation_amt"] . "</td><td>" . $row["cmp_Date"] . "</td><td>" . $row["clearance"] . "</td>";
                                    echo "<td><button data-id=" . $row["employee_id"] . " class='btn btn-info compinfo'>View</button></td></tr>";
                                }

                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-solid fa-indian-rupee-sign'></i>
                               <i class='fa-solid fa-receipt'></i>
                               </div>
                               <div class='empty-state__message'>All Past Compensation Payments are Cleared</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span><br>
                               Add new payments by clicking the button Add New and Clear the Payments to view records here.
                               </div>
                               </div>
                               </div>";
                            }
                            ?>
                        </div><!-- /.Compensation -->

                    </div><!-- /.Tab-panes -->

                    <!-- Modal-Compensation Insert -->
                    <div class="modal fade" id="modal_insert_comp" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="overflow:hidden;">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Compensation form: </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container p-5 my-2 border">
                                        <h2>Enter Compensation Record:</h2><br>
                                        <form name="Comp_form" action="comp_insert.php" method="POST">

                                            <div class="form-inline">
                                                <label for="compdate" class="form-label">Date : </label>
                                                <div class="col-sm-2">
                                                    <input type="date" class="form-control" id="compdate" name="compdate" required>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label for="emp" class="form-label">Select Employee: </label>
                                                <select id="emp" class="form-control select2bs4" name="emp" style="width: 100%;" required>
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

                                            <div class="form-group">
                                                <label for="comptype" class="form-label">Type: </label>
                                                <input type="text" class="form-control" id="comptype" name="comptype" required>
                                            </div>
                                            <br>

                                            <div class="form-inline">
                                                <label for="compamt" class="form-label">Amount (Rs): </label>
                                                <div class="col-sm-2">
                                                    <input type="number" class="form-control" id="compamt" name="compamt" required>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label for="compdesc" class="form-label">Description: </label>
                                                <textarea type="text" class="form-control" rows="5" cols="33" id="compdesc" name="compdesc"></textarea>
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

                    <!-- Modal otppayinfo View -->
                    <div class="modal fade" id="modal_view_Otppay" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="overflow:hidden;">
                        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Overtime Pay Records (per day):</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                                </div>
                                <div id="modal-body-Otppay" class="modal-body">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.Modal -->

                    <!-- Modal compinfo View -->
                    <div class="modal fade" id="modal_view_comp" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="overflow:hidden;">
                        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Compensation Records:</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                                </div>
                                <div id="modal-body-comp" class="modal-body">

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

            $('.otppayinfo').click(function() {

                var userid = $(this).data('id');

                // AJAX request
                $.ajax({
                    url: 'ajax_Otppay.php',
                    type: 'post',
                    data: {
                        userid: userid
                    },
                    success: function(response) {
                        // Add response in Modal body
                        $('#modal-body-Otppay').html(response);

                        // Display Modal
                        $('#modal_view_Otppay').modal('show');
                    }
                });
            });
        });

        $(document).ready(function() {

            $('.compinfo').click(function() {

                var userid = $(this).data('id');

                // AJAX request
                $.ajax({
                    url: 'ajax_comp.php',
                    type: 'post',
                    data: {
                        userid: userid
                    },
                    success: function(response) {
                        // Add response in Modal body
                        $('#modal-body-comp').html(response);

                        // Display Modal
                        $('#modal_view_comp').modal('show');
                    }
                });
            });
        });
    </script>
    <!-- /.scripts -->
</body>

</html>