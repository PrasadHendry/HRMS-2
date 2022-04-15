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
    <title>HRMS | Time</title>

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
                                <li class="breadcrumb-item active">Time and Attendance</li>
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
                        <h2>Time and Attendance: </h2>
                    </div>
                    <br>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="hisTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 0) echo "active"; ?>" id="attendace-tab" data-toggle="tab" href="#attendace" role="tab" aria-controls="attendace" aria-selected="<?php if ($count == 0) echo "true";
                                                                                                                                                                                                    else echo "false"; ?>">Attendance</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 1) echo "active"; ?>" id="Hisatt-tab" data-toggle="tab" href="#Hisatt" role="tab" aria-controls="Hisatt" aria-selected="<?php if ($count == 1) echo "true";
                                                                                                                                                                                            else echo "false"; ?>">Attendance records</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 2) echo "active"; ?>" id="leave_types-tab" data-toggle="tab" href="#leave_types" role="tab" aria-controls="leave_types" aria-selected="<?php if ($count == 2) echo "true";
                                                                                                                                                                                                            else echo "false"; ?>">Leave types</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 3) echo "active"; ?>" id="leaves-tab" data-toggle="tab" href="#leaves" role="tab" aria-controls="leaves" aria-selected="<?php if ($count == 3) echo "true";
                                                                                                                                                                                            else echo "false"; ?>">Leave management</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 4) echo "active"; ?>" id="leaverec-tab" data-toggle="tab" href="#leaverec" role="tab" aria-controls="leaverec" aria-selected="<?php if ($count == 4) echo "true";
                                                                                                                                                                                                    else echo "false"; ?>">Leave Records</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- attendace -->
                        <div class="tab-pane fade <?php if ($count == 0) echo "show active"; ?>" id="attendace" role="tabpanel" aria-labelledby="attendace-tab">
                            <button type="button" data-toggle="modal" data-target="#modal_clock_in" class="btn btn-outline-success" style="float:right">
                                <i class="fas fa-stopwatch"></i> Clock-in

                            </button>
                            <br><br>
                            <?php

                            // retrieves all attendance records
                            $result = $conn->query("SELECT * FROM attendance where clock_out_val = 0 order by employee_id");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Employee ID" . "</th><th>" . "Employee Name" . "</th><th>" . "Clock-in" . "</th><th>" . "Clock-out" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {

                                    $emp_row = mysqli_query($conn, "select * from employee_information where employee_id = '$row[employee_id]'");
                                    $emp_row = $emp_row->fetch_assoc();

                                    echo "<tr><td>" . $row["employee_id"] . "</td><td>" . $emp_row["employee_name"] . "</td><td>" . $row["clock_in"] . "</td>";
                            ?>
                                    <td><a href="attendance_clock_out.php?aid=<?php echo $row['attendance_id'] ?>"><button type="submit" class="btn btn-warning">Clock-out</button></a></td>
                                    </tr>
                            <?php
                                }

                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-regular fa-clock'></i>
                               </div>
                               <div class='empty-state__message'>No attendance data</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span>
                               Add new attendance data by clicking the button clock-in.
                               </div>
                               </div>
                               </div>";
                            }
                            ?>
                        </div><!-- /.attendace -->

                        <!-- attendace history-->
                        <div class="tab-pane fade <?php if ($count == 1) echo "show active"; ?>" id="Hisatt" role="tabpanel" aria-labelledby="Hisatt-tab">
                            <br>
                            <p>These are attendance records:</p>
                            <br>
                            <?php

                            // retrieves all attendance records
                            $result = $conn->query("SELECT * FROM attendance where clock_out is not null group by employee_id desc");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Employee ID" . "</th><th>" . "Employee Name" . "</th><th>" . "Clock-in" . "</th><th>" . "Clock-out" . "</th><th>" . "Shift" . "</th><th>" . "Action" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {

                                    $emp_row = mysqli_query($conn, "select * from employee_information where employee_id = '$row[employee_id]'");
                                    $emp_row = $emp_row->fetch_assoc();

                                    echo "<tr><td>" . $row["employee_id"] . "</td><td>" . $emp_row["employee_name"] . "</td><td>" . $row["clock_in"] . "</td><td>" . $row["clock_out"] . "</td><td>" . $row["shift"] . "</td>";
                                    echo "<td><button data-id=" . $row["employee_id"] . " class='btn btn-info attinfo'>View</button></td></tr>";
                            ?>
                            <?php
                                }

                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-regular fa-clock'></i>
                               </div>
                               <div class='empty-state__message'>No attendance records</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span>
                               Add new attendance data by clicking the button clock-in in Attendance tab.
                               </div>
                               </div>
                               </div>";
                            }

                            ?>
                        </div><!-- /.attendace History-->

                        <!-- leave types -->
                        <div class="tab-pane fade <?php if ($count == 2) echo "show active"; ?>" id="leave_types" role="tabpanel" aria-labelledby="leave_types-tab">
                            <button type="button" data-toggle="modal" data-target="#modal_insert_leavetype" class="btn btn-outline-success" style="float:right">
                                <i class="fas fa-scroll"></i> Add Types

                            </button>
                            <br><br>
                            <?php

                            if (isset($_GET["e"])) {
                                echo "<div class='alert alert-warning alert-dismissible fade show' style='font-size: large; text-align:center;'>
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                <strong>Warning! </strong>The Leave type already exists.
                            </div>";
                            }

                            // retrieves all leave_types records
                            $result = $conn->query("SELECT * FROM leave_types");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Type ID" . "</th><th>" . "Leave Type" . "</th><th colspan = '2'>" . "Actions" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {


                                    echo "<tr><td>" . $row["type_id"] . "</td><td>" . $row["types"] . "</td>";
                            ?>
                                    <td><button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal_update_leavetype<?php echo $row["type_id"]; ?>">Update</button></td>
                                    <td><a href="leavetype_delete.php?lid=<?php echo $row['type_id'] ?>"><button type="submit" class="btn btn-danger">Delete</button></a></td>
                                    </tr>
                            <?php

                                    include 'leavetype_update.php';
                                }

                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-solid fa-leaf'></i>
                               </div>
                               <div class='empty-state__message'>No Leave types</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span>
                               Add new Leave types by clicking Add Types.
                               </div>
                               </div>
                               </div>";
                            }

                            ?>
                        </div>
                        <!-- /.leave types -->

                        <!-- leave management -->
                        <div class="tab-pane fade <?php if ($count == 3) echo "show active"; ?>" id="leaves" role="tabpanel" aria-labelledby="leaves-tab">
                            <button type="button" data-toggle="modal" data-target="#modal_insert_leave" class="btn btn-outline-success" style="float:right">
                                <i class="fas fa-scroll"></i> Add Leaves

                            </button>
                            <br><br>
                            <?php

                            if (isset($_GET["el"])) {
                                echo "<div class='alert alert-warning alert-dismissible fade show' style='font-size: large; text-align:center;'>
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                <strong>Warning! </strong>End Date can not be prior to Start Date.
                            </div>";
                            }

                            // retrieves all leaves records
                            $result = $conn->query("SELECT * FROM leaves where approval='pending' order by employee_id");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Employee ID" . "</th><th>" . "Employee Name" . "</th><th>" . "Type" . "</th><th>" . "Start Date" . "</th><th>" . "End Date" .  "</th><th>" . "Reason" . "</th><th>" . "Approval" . "</th><th colspan = '2'>" . "Actions" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {

                                    // fetches employee details
                                    $emp_row = mysqli_query($conn, "select * from employee_information where employee_id = '$row[employee_id]'");
                                    $emp_row = $emp_row->fetch_assoc();

                                    // fetches type details
                                    $type_row = mysqli_query($conn, "select * from leave_types where type_id = '$row[type_id]'");
                                    $type_row = $type_row->fetch_assoc();

                                    echo "<tr><td>" . $row["employee_id"] . "</td><td>" . $emp_row["employee_name"] . "</td><td>" . $type_row["types"] . "</td><td>" . $row["leave_start_date"] . "</td><td>" . $row["leave_end_date"] . "</td><td>" . $row["reason"] . "</td><td>" . $row["approval"] . "</td>";
                                    if ($row["approval"] == "approved") {
                                        echo "<td><button type='submit' class='btn btn-secondary' disabled>Approved</button></td></tr>";
                                    } else {
                            ?>
                                        <td><a href='leave_accept.php?lacc=<?php echo $row["leave_id"]; ?>'><button type='submit' class='btn btn-success'>Accept</button></a></td>
                                        <td><a href='leave_reject.php?lacc=<?php echo $row["leave_id"]; ?>'><button type='submit' class='btn btn-danger'>Reject</button></a></td>
                                        </tr>
                            <?php

                                    }
                                }

                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-solid fa-leaf'></i>
                               </div>
                               <div class='empty-state__message'>No Leave data</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span>
                               Add new Leave data by clicking Add Leaves.
                               </div>
                               </div>
                               </div>";
                            }
                            ?>
                        </div>
                        <!-- /.leave management -->

                        <!-- leave records -->
                        <div class="tab-pane fade <?php if ($count == 4) echo "show active"; ?>" id="leaverec" role="tabpanel" aria-labelledby="leaverec-tab">
                            <br>
                            <p>These are Leave records:</p>
                            <br>
                            <?php

                            // retrieves all leaves records
                            $result = $conn->query("SELECT * FROM leaves where approval!='pending' group by employee_id order by leave_id desc");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Employee ID" . "</th><th>" . "Employee Name" . "</th><th>" . "Type" . "</th><th>" . "Start Date" . "</th><th>" . "End Date" .  "</th><th>" . "Reason" . "</th><th>" . "Approval" . "</th><th colspan = '2'>" . "Actions" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {

                                    // fetches employee details
                                    $emp_row = mysqli_query($conn, "select * from employee_information where employee_id = '$row[employee_id]'");
                                    $emp_row = $emp_row->fetch_assoc();

                                    // fetches type details
                                    $type_row = mysqli_query($conn, "select * from leave_types where type_id = '$row[type_id]'");
                                    $type_row = $type_row->fetch_assoc();

                                    echo "<tr><td>" . $row["employee_id"] . "</td><td>" . $emp_row["employee_name"] . "</td><td>" . $type_row["types"] . "</td><td>" . $row["leave_start_date"] . "</td><td>" . $row["leave_end_date"] . "</td><td>" . $row["reason"] . "</td><td>" . $row["approval"] . "</td>";
                                    echo "<td><button data-id=" . $row["employee_id"] . " class='btn btn-info leaveinfo'>View</button></td></tr>";
                                }

                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-solid fa-calendar-week'></i>
                               </div>
                               <div class='empty-state__message'>No Leave records</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span><br>
                               Add new Leave data by clicking Add Leaves in Leave Management under Leave Management.
                               </div>
                               </div>
                               </div>";
                            }

                            ?>
                        </div><!-- /.leave records -->


                    </div><!-- /.Tab-panes -->

                    <!-- modal_clock_in -->
                    <div class="modal fade" id="modal_clock_in" data-backdrop="static" data-keyboard="false" style="overflow:hidden;" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Attendance form: </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container p-5 my-2 border">
                                        <h2>Enter Attendance details here:</h2><br>
                                        <form name="attendace_form" action="attendance_clock_in.php" method="POST">

                                            <div class="form-group">
                                                <label for="att_emp" class="form-label">Select Employee: </label>
                                                <select id="att_emp" class="form-control select2bs4" name="att_emp" style="width: 100%;" required>
                                                    <?php
                                                    // retrieving all employee_information
                                                    $result = $conn->query("SELECT employee_id, employee_name FROM employee_information WHERE employee_id NOT IN (SELECT employee_id FROM attendance WHERE clock_out_val = 0 GROUP BY employee_id);");

                                                    while ($row = $result->fetch_assoc()) {
                                                        // displaying each employee_information in the list
                                                        echo "<option value = '$row[employee_id]'>" . $row["employee_name"] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div><br>

                                            <div class="form-group">
                                                <label for="shift">Select shift:</label>
                                                <select id="shift" name="shift" class="custom-select" required>
                                                    <option value="8:00 am to 4:00 pm">8:00 am to 4:00 pm</option>
                                                    <option value="4:00 pm to 12:00 pm">4:00 pm to 12:00 pm</option>
                                                    <option value="12:00 am to 8:00 am">12:00 am to 8:00 am</option>
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

                    <!-- modal_add_leave_type -->
                    <div class="modal fade" id="modal_insert_leavetype" data-backdrop="static" data-keyboard="false" style="overflow:hidden;" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Leave Type form: </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container p-5 my-2 border">
                                        <h2>Enter details here:</h2><br>
                                        <form name="attendace_form" action="leavetype_insert.php" method="POST">

                                            <div class="form-group">
                                                <label for="leavetype" class="form-label">Leave type: </label>
                                                <input type="text" class="form-control" id="leavetype" name="leavetype" required>
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

                    <!-- modal_add_leave -->
                    <div class="modal fade" id="modal_insert_leave" data-backdrop="static" data-keyboard="false" style="overflow:hidden;" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Leave form: </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container p-5 my-2 border">
                                        <h2>Enter details here:</h2><br>
                                        <form name="attendace_form" action="leave_insert.php" method="POST">

                                            <div class="form-group">
                                                <label for="leavetype" class="form-label">Select Type: </label>
                                                <select id="leavetype" class="form-control select2bs4" name="leavetype" style="width: 100%;" required>
                                                    <?php
                                                    // retrieving all leave_types
                                                    $result = $conn->query("select * from leave_types");

                                                    while ($row = $result->fetch_assoc()) {
                                                        // displaying each leave_types in the list
                                                        echo "<option value = '$row[type_id]'>" . $row["types"] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div><br>


                                            <div class="form-group">
                                                <label for="leave_emp" class="form-label">Select Employee: </label>
                                                <select id="leave_emp" class="form-control select2bs4" name="leave_emp" style="width: 100%;" required>
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
                                                <label for="leave_sdate" class="form-label">Leave Start Date: </label>
                                                <div class="col-sm-2">
                                                    <input type="date" class="form-control" id="leave_sdate" name="leave_sdate" required>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-inline">
                                                <label for="leave_edate" class="form-label">Leave End Date: </label>
                                                <div class="col-sm-2">
                                                    <input type="date" class="form-control" id="leave_edate" name="leave_edate" required>
                                                </div>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label for="reason" class="form-label">Reason: </label>
                                                <textarea type="text" class="form-control" rows="5" cols="33" id="reason" name="reason"></textarea>
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

                    <!-- Modal leave View -->
                    <div class="modal fade" id="modal_view_Leaves" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="overflow:hidden;">
                        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Leave Records</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                                </div>
                                <div id="modal-body-leave" class="modal-body">

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.Modal -->

                    <!-- attendance view View -->
                    <div class="modal fade" id="modal_view_att" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="overflow:hidden;">
                        <div class="modal-dialog modal-dialog-scrollable modal-xl modal-dialog-centered">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Attendance Records</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                                </div>
                                <div id="modal-body-att" class="modal-body">

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

            $('.leaveinfo').click(function() {

                var userid = $(this).data('id');

                // AJAX request
                $.ajax({
                    url: 'ajax_leaves.php',
                    type: 'post',
                    data: {
                        userid: userid
                    },
                    success: function(response) {
                        // Add response in Modal body
                        $('#modal-body-leave').html(response);

                        // Display Modal
                        $('#modal_view_Leaves').modal('show');
                    }
                });
            });
        });

        $(document).ready(function() {

            $('.attinfo').click(function() {

                var userid = $(this).data('id');

                // AJAX request
                $.ajax({
                    url: 'ajax_attendance.php',
                    type: 'post',
                    data: {
                        userid: userid
                    },
                    success: function(response) {
                        // Add response in Modal body
                        $('#modal-body-att').html(response);

                        // Display Modal
                        $('#modal_view_att').modal('show');
                    }
                });
            });
        });
    </script>

    <!-- /.scripts -->
</body>

</html>