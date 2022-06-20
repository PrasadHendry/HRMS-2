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
    <title>HRMS | Employee</title>

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
                                <li class="breadcrumb-item active">Employees</li>
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
                        <h2>Employee Details: </h2>
                    </div>
                    <br>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="empTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 0) echo "active"; ?>" id="details-tab" data-toggle="tab" href="#details" role="tab" aria-controls="details" aria-selected="<?php if ($count == 0) echo "true"; ?>">Details</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 1) echo "active"; ?>" id="contacts-tab" data-toggle="tab" href="#contacts" role="tab" aria-controls="contacts" aria-selected="<?php if ($count == 1) echo "true"; ?>">Contacts</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 2) echo "active"; ?>" id="qualifications-tab" data-toggle="tab" href="#qualifications" role="tab" aria-controls="qualifications" aria-selected="<?php if ($count == 2) echo "true"; ?>">Qualifications</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 3) echo "active"; ?>" id="empDesg-tab" data-toggle="tab" href="#empDesg" role="tab" aria-controls="empDesg" aria-selected="<?php if ($count == 3) echo "true"; ?>">Employee designations &nbsp;
                                <?php
                                // retrieving number of employees without designations
                                $result = mysqli_query($conn, "select count(*) from employee_information where designation_id is null");
                                $row = $result->fetch_assoc();

                                // if there is atleast one employee without a designation, shows a count of employees without designations
                                if ($row["count(*)"] > 0)
                                    echo "<span data-toggle='tooltip' data-placement='top' title='△ Designations Not Set △' class='badge badge-danger right'>" . $row["count(*)"] . "</span>";
                                ?>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 4) echo "active"; ?>" id="personal_sal-tab" data-toggle="tab" href="#personal_sal" role="tab" aria-controls="personal_sal" aria-selected="<?php if ($count == 4) echo "true"; ?>">Personal Salary</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane fade <?php if ($count == 0) echo "show active"; ?>" id="details" role="tabpanel" aria-labelledby="details-tab">
                            <?php

                            if (isset($_GET["e"])) {
                                echo "<div class='alert alert-warning alert-dismissible fade show' style='font-size: large; text-align:center;'>
                                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                        <strong>Warning! </strong>The date entered is invalid. Age must be between 18 and 60.
                                    </div>";
                            }
                            // retrieves all employee information records
                            $result = $conn->query("SELECT * FROM employee_information");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Employee ID" . "</th><th>" . "Full name" . "</th><th>" . "Date of Birth" . "</th><th>" . "Age" . "</th><th>" . "Gender" . "</th><th>" . "Address" . "</th><th>" . "E-mail" . "</th><th colspan = '2'>" . "Actions" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {

                                    $emp_email = $row["employee_email"];
                                    echo "<tr><td>" . $row["employee_id"] . "</td><td>" . $row["employee_name"] . "</td><td>" . $row["employee_dob"] . "</td><td>" . $row["employee_age"] . "</td><td>" . $row["employee_gender"] . "</td><td>" . $row["employee_address"] . "</td><td id = 'email_td'><a href='mailto:$emp_email' class='hyperlinked_emails'>$emp_email</a></td>";

                            ?>

                                    <td><button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal_update<?php echo $row["employee_id"]; ?>">Update</button></td>
                                    <td><a href="emp_delete.php?del=<?php echo $row["employee_id"]; ?>"><button type="submit" class="btn btn-danger">Delete</button></td>
                                    </tr>

                            <?php
                                    include 'emp_upd.php';
                                }

                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-solid fa-id-card'></i>
                               </div>
                               <div class='empty-state__message'>No Employee data</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span>
                               Add new employees by adding them as candidates in Candidate Details tab.
                               </div>
                               </div>
                               </div>";
                            }


                            ?>
                        </div><!-- /.Details -->

                        <div class="tab-pane fade <?php if ($count == 1) echo "show active"; ?>" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                            <?php

                            // retrieves all employee_phnum records
                            $result = $conn->query("SELECT * FROM employee_phnum");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Employee ID" . "</th><th>" . "Employee name" . "</th><th>" . "Home" . "</th><th>" . "Work" . "</th><th>" . "Mobile" . "</th><th>" . "Action" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {

                                    $res = $conn->query("select * from employee_information where employee_id = $row[employee_id]");
                                    $res = $res->fetch_assoc();

                                    echo "<tr><td>" . $res["employee_id"] . "</td><td>" . $res["employee_name"] . "</td><td>";
                                    if ($row["phnum_home"] == null || $row["phnum_home"] == 0) echo "Not added</td><td>";
                                    else echo $row["phnum_home"] . "</td><td>";
                                    if ($row["phnum_work"] == null || $row["phnum_work"] == 0) echo "Not added</td><td>";
                                    else echo $row["phnum_work"] . "</td><td>";
                                    if ($row["phnum_mobile"] == null || $row["phnum_mobile"] == 0) echo "Not added</td>";
                                    else echo $row["phnum_mobile"] . "</td>";

                            ?>

                                    <td><button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal_update_contact<?php echo $row["employee_id"]; ?>">Update</button></td>
                                    </tr>

                            <?php
                                    include 'emp_upd_contact.php';
                                }

                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-solid fa-phone-slash'></i>
                               </div>
                               <div class='empty-state__message'>No Contacts data</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span>
                               Add new employees by adding them as candidates in Candidate Details tab.
                               </div>
                               </div>
                               </div>";
                            }

                            ?>
                        </div><!-- /.Contacts -->

                        <div class="tab-pane fade<?php if ($count == 2) echo "show active"; ?>" id="qualifications" role="tabpanel" aria-labelledby="qualifications-tab">
                            <?php

                            // retrieves all employee_qualifications records
                            $result = $conn->query("SELECT * FROM employee_qualifications");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Employee ID" . "</th><th>" . "Employee name" . "</th><th>" . "Qualifications" . "</th><th>" . "Action" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {

                                    $res = $conn->query("select * from employee_information where employee_id = $row[employee_id]");
                                    $res = $res->fetch_assoc();

                                    echo "<tr><td>" . $res["employee_id"] . "</td><td>" . $res["employee_name"] . "</td><td>" . $row["qualifications_file_location"] . "</td>";

                            ?>

                                    <td><button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal_update_qualif<?php echo $row["employee_id"]; ?>">Update</button></td>
                                    </tr>

                            <?php
                                    include 'emp_upd_qualif.php';
                                }

                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-regular fa-file'></i>
                               </div>
                               <div class='empty-state__message'>No Qualification data</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span>
                               Add new employees by adding them as candidates in Candidate Details tab.
                               </div>
                               </div>
                               </div>";
                            }

                            ?>
                        </div><!-- /.Qualifications -->

                        <div class="tab-pane fade <?php if ($count == 3) echo "show active"; ?>" id="empDesg" role="tabpanel" aria-labelledby="empDesg-tab">
                            <button type="button" data-toggle="modal" data-target="#modal_set_desg" class="btn btn-outline-success" style="float:right">
                                <i class="fas fa-user-cog"></i> Set Designation
                            </button><br><br>

                            <?php
                            // retrieves all employees that don't have designations assigned to them
                            $result = $conn->query("SELECT * FROM employee_information where designation_id IS NOT NULL");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Employee ID" . "</th><th>" . "Employee name" . "</th><th>" . "Department" . "</th><th>" . "Designation" . "</th><th>" . "Action" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {

                                    $res_des = $conn->query("select * from designations where designation_id = '$row[designation_id]'");
                                    $res_des = $res_des->fetch_assoc();
                                    $res_dpt = $conn->query("select * from department where department_id = '$res_des[department_id]'");
                                    $res_dpt = $res_dpt->fetch_assoc();

                                    echo "<tr><td>" . $row["employee_id"] . "</td><td>" . $row["employee_name"] . "</td><td>" . $res_dpt["department_name"] . "</td><td>" . $res_des["designation"] . "</td>";

                            ?>

                                    <td><button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal_update_desg<?php echo $row["employee_id"]; ?>">Update</button></td>
                                    </tr>

                            <?php
                                    include 'emp_desg.php';
                                }

                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-solid fa-user-tie'></i>
                               </div>
                               <div class='empty-state__message'>No Designations data</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span><br>
                               Add new employees by adding them as candidates in Candidate Details tab or <br>Add designations in Designations tab under Compny Structure tab.
                               </div>
                               </div>
                               </div>";
                            }

                            ?>
                        </div><!-- /.Employee designations -->

                        <div class="tab-pane fade <?php if ($count == 4) echo "show active"; ?>" id="personal_sal" role="tabpanel" aria-labelledby="personal_sal-tab">
                            <br><br>

                            <?php
                            // retrieves all employees' salaries who have designations
                            $result = $conn->query("SELECT * FROM emp_personal_sal");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Employee ID" . "</th><th>" . "Employee name" . "</th><th>" . "Designation" . "</th><th>" . "Salary Amount(Rs.)" . "</th><th>" . "Edit Salary" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {

                                    // retreiving employee information
                                    $res_emp = $conn->query("select * from employee_information where employee_id = '$row[employee_id]'");
                                    $res_emp = $res_emp->fetch_assoc();

                                    // retreiving employee designation information
                                    $res_des = $conn->query("select * from designations where designation_id = '$res_emp[designation_id]'");
                                    $res_des = $res_des->fetch_assoc();

                                    echo "<tr><td>" . $res_emp["employee_id"] . "</td><td>" . $res_emp["employee_name"] . "</td><td>" . $res_des["designation"] . "</td><td>" . $row["salary_amount_rec"] . "</td>";

                            ?>

                                    <td><button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal_edit_personal_sal<?php echo $row["employee_id"]; ?>">Edit</button></td>
                                    </tr>

                            <?php
                                    include 'emp_personal_sal.php';
                                }

                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-solid fa-indian-rupee-sign'></i> 
                               </div>
                               <div class='empty-state__message'>No Personal Salary data</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span><br>
                               These records are of each employee's personal salary amount that is edited for increments or decrements from the employee's base salary.
                               </div>
                               </div>
                               </div>";
                            }

                            ?>
                        </div><!-- /.Employee Personal Salary -->

                    </div><!-- /.Tab-panes -->

                    <!-- Modal-Set Designations -->
                    <div class="modal fade" id="modal_set_desg" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="overflow:hidden;">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Designation form: </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container p-5 my-2 border">
                                        <h2>Assign designation:</h2><br>
                                        <form name="set_desg_form" action="emp_desg_set.php" method="POST">

                                            <div class="form-group">
                                                <label for="empname" class="form-label">Select Employee: </label>
                                                <select id="empname" class="form-control select2bs4" name="empname" style="width:100%;" required>
                                                    <?php
                                                    // retrieving all employee_information
                                                    $result = $conn->query("select * from employee_information where designation_id is null");

                                                    while ($row = $result->fetch_assoc()) {
                                                        // displaying each employee_information in the list
                                                        echo "<option value = '$row[employee_id]'>" . $row["employee_name"] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div><br>

                                            <div class="form-group">
                                                <label for="design" class="form-label">Select Designation: </label>
                                                <select id="design" class="form-control select2bs4" name="design" style="width:100%;" required>
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