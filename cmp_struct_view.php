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
    <title>HRMS | Company</title>

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
                                <li class="breadcrumb-item active">Company Structure</li>
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
                        <h2>Company Structure: </h2>
                    </div>
                    <br>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="cmpTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 0) echo "active"; ?>" id="department-tab" data-toggle="tab" href="#department" role="tab" aria-controls="department" aria-selected="<?php if ($count == 0) echo "true";
                                                                                                                                                                                                        else echo "false"; ?>">Departments</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 1) echo "active"; ?>" id="designation-tab" data-toggle="tab" href="#designation" role="tab" aria-controls="designation" aria-selected="<?php if ($count == 1) echo "true";
                                                                                                                                                                                                            else echo "false"; ?>">Designations</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">

                        <!-- department -->
                        <div class="tab-pane fade <?php if ($count == 0) echo "show active"; ?>" id="department" role="tabpanel" aria-labelledby="department-tab">
                            <button type="button" data-toggle="modal" data-target="#modal_insert_dept" class="btn btn-outline-success" style="float:right">
                                <i class="fas fa-plus"></i> Add New
                            </button>
                            <br><br>

                            <?php
                            if (isset($_GET["e"])) {
                                echo "<div class='alert alert-warning alert-dismissible fade show' style='font-size: large; text-align:center;'>
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                <strong>Warning! </strong>The department already exists.
                            </div>";
                            }

                            // retrieves all department information records
                            $result = $conn->query("SELECT * FROM department");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Department ID" . "</th><th>" . "Name" . "</th><th>" . "Location" . "</th><th colspan = '2'>" . "Actions" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr><td>" . $row["department_id"] . "</td><td>" . $row["department_name"] . "</td><td>" . $row["department_location"] . "</td>";

                            ?>

                                    <td><button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal_update_dept<?php echo $row["department_id"]; ?>">Update</button></td>
                                    <td><a href="department_delete.php?del=<?php echo $row["department_id"]; ?>"><button type="submit" class="btn btn-danger">Delete</button></td>
                                    </tr>

                            <?php
                                    include 'department_upd.php';
                                }

                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-solid fa-building'></i>
                               </div>
                               <div class='empty-state__message'>No Department data</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span>
                               Add departments in Department tab under Compny Structure tab.
                               </div>
                               </div>
                               </div>";
                            }

                            ?>
                        </div><!-- /.department -->

                        <!-- designation -->
                        <div class="tab-pane fade <?php if ($count == 1) echo "show active"; ?>" id="designation" role="tabpanel" aria-labelledby="designation-tab">
                            <button type="button" data-toggle="modal" data-target="#modal_insert_desg" class="btn btn-outline-success" style="float:right">
                                <i class="fas fa-plus"></i> Add New

                            </button>
                            <br><br>
                            <?php
                            if (isset($_GET["ed"])) {
                                echo "<div class='alert alert-warning alert-dismissible fade show' style='font-size: large; text-align:center;'>
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                <strong>Warning! </strong>The designation already exists.
                            </div>";
                            }

                            // retrieves all designation information records
                            $result = $conn->query("SELECT * FROM designations");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Designation ID" . "</th><th>" . "Department" . "</th><th>" . "Designation" . "</th><th>" . "Base Salary(Rs.)" .  "</th><th>" . "Overtime Pay (Rs.)" . "</th><th colspan = '2'>" . "Actions" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {

                                    $res = $conn->query("select * from department where department_id = $row[department_id]");
                                    $res = $res->fetch_assoc();

                                    echo "<tr><td>" . $row["designation_id"] . "</td><td>" . $res["department_name"] . "</td><td>" . $row["designation"] . "</td><td>" . $row["base_salary"] .  "</td><td>" . $row["amt_per_hour"] . "</td>";

                            ?>

                                    <td><button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal_update_desg<?php echo $row["designation_id"]; ?>">Update</button></td>
                                    <td><a href="designation_delete.php?del=<?php echo $row["designation_id"]; ?>"><button type="submit" class="btn btn-danger">Delete</button></td>
                                    </tr>

                            <?php
                                    include 'designation_upd.php';
                                }

                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-solid fa-user-tie'></i>
                               </div>
                               <div class='empty-state__message'>No Designations data</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span>
                               Add designations in Designations tab under Compny Structure tab.
                               </div>
                               </div>
                               </div>";
                            }

                            ?>
                        </div><!-- /.designation -->


                    </div><!-- /.Tab-panes -->

                    <!-- Modal-Department Insert -->
                    <div class="modal fade" id="modal_insert_dept" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Department form: </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container p-5 my-2 border">
                                        <h2>Enter Department details here:</h2><br>
                                        <form name="dept_form" action="department_insert.php" method="POST">

                                            <div class="form-group">
                                                <label for="deptname" class="form-label">Department Name: </label>
                                                <input type="text" class="form-control" id="deptname" name="deptname" required>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label for="deptloc" class="form-label">Department Location: </label>
                                                <textarea type="text" class="form-control" rows="5" cols="33" id="deptloc" name="deptloc" required></textarea>
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

                    <!-- Modal-Designation Insert -->
                    <div class="modal fade" id="modal_insert_desg" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="overflow:hidden;">
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
                                        <h2>Enter Designation details here:</h2><br>
                                        <form name="desg_form" action="designation_insert.php" method="POST">

                                            <div class="form-group">
                                                <label for="deptname" class="form-label">Select Department: </label>
                                                <select id="deptname" class="form-control select2bs4" name="deptname" style="width: 100%;" required>
                                                    <?php
                                                    // retrieving all departments
                                                    $result = $conn->query("select * from department");

                                                    while ($row = $result->fetch_assoc()) {
                                                        // displaying each department in the list
                                                        echo "<option value = '$row[department_id]'>" . $row["department_name"] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div><br>

                                            <div class="form-group">
                                                <label for="desgname" class="form-label">Designation: </label>
                                                <input type="text" class="form-control" id="desgname" name="desgname" required>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label for="basesal" class="form-label">Base Salary: </label>
                                                <input type="number" class="form-control" id="basesal" name="basesal" required>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label for="otp_amt" class="form-label">Overtime Pay: </label>
                                                <input type="number" class="form-control" id="otp_amt" name="otp_amt" placeholder="Amount-per-hour(Rs)" required>
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