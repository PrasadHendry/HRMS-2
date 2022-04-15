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
    <title>HRMS | Users</title>

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
                                <li class="breadcrumb-item active">User Registrations</li>
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
                        <h2>User Registrations: </h2>
                    </div>
                    <br>

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="cmpTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 0) echo "active"; ?>" id="role-tab" data-toggle="tab" href="#role" role="tab" aria-controls="role" aria-selected="<?php if ($count == 0) echo "true";
                                                                                                                                                                                        else echo "false"; ?>">Login/user Role</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link <?php if ($count == 1) echo "active"; ?>" id="login-tab" data-toggle="tab" href="#login" role="tab" aria-controls="login" aria-selected="<?php if ($count == 1) echo "true";
                                                                                                                                                                                        else echo "false"; ?>">Users Registrations</a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <!-- role -->
                        <div class="tab-pane fade <?php if ($count == 0) echo "show active"; ?>" id="role" role="tabpanel" aria-labelledby="role-tab">
                            <button type="button" data-toggle="modal" data-target="#modal_insert_role" class="btn btn-outline-success" style="float:right">
                                <i class="fas fa-plus"></i> Add New

                            </button>
                            <br><br>
                            <?php

                            if (isset($_GET["er"])) {
                                echo "<div class='alert alert-warning alert-dismissible fade show' style='font-size: large; text-align:center;'>
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                <strong>Warning! </strong>User role already exists.
                            </div>";
                            }

                            // retrieves all role information records
                            $result = $conn->query("SELECT * FROM user_role order by role_id");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "Role ID" . "</th><th>" . "Role" . "</th><th>" . "Action" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr><td>" . $row["role_id"] . "</td><td>" . $row["role"] . "</td>";

                                    if ($row["role_id"] != 1) {
                            ?>
                                        <td><a href="user_role_delete.php?del=<?php echo $row["role_id"]; ?>"><button type="submit" class="btn btn-danger">Delete</button></td>
                                        </tr>

                            <?php
                                    } else
                                        echo "<td><button class='btn btn-danger' disabled>Cannot delete</button></td></tr>";
                                }

                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-regular fa-circle-user'></i>
                               </div>
                               <div class='empty-state__message'>No Role data</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span>
                               Add login/user role by clicking Add new.
                               </div>
                               </div>
                               </div>";
                            }

                            ?>
                        </div><!-- /.Role -->

                        <!-- login -->
                        <div class="tab-pane fade <?php if ($count == 1) echo "show active"; ?>" id="login" role="tabpanel" aria-labelledby="login-tab">
                            <button type="button" data-toggle="modal" data-target="#modal_insert_user" class="btn btn-outline-success" style="float:right">
                                <i class="fas fa-plus"></i> Add New

                            </button>
                            <br><br>
                            <?php

                            if (isset($_GET["e"])) {
                                echo "<div class='alert alert-warning alert-dismissible fade show' style='font-size: large; text-align:center;'>
                                <button type='button' class='close' data-dismiss='alert'>&times;</button>
                                <strong>Warning! </strong>The User already exists.
                            </div>";
                            }

                            // retrieves all login information records
                            $result = $conn->query("SELECT * FROM user_details");

                            if ($result->num_rows > 0) {
                                // displaying header for tabular form
                                echo "<table style='text-align:center; background-color:white;' class='table table-bordered'>" . "<tr><th>" . "User ID" . "</th><th>" . "Role" . "</th><th>" . "User Name" . "</th><th colspan = '2'>" . "Actions" . "</th></tr>";

                                // displaying data along with adding buttons for update and delete
                                while ($row = $result->fetch_assoc()) {

                                    $res = mysqli_query($conn, "select role from user_role where role_id = '$row[role_id]'");
                                    $res = $res->fetch_assoc();
                                    echo "<tr><td>" . $row["user_id"] . "</td><td>" . $res["role"] . "</td><td>" . $row["username"] . "</td>";
                            ?>
                                    <td><button type="submit" class="btn btn-warning" data-toggle="modal" data-target="#modal_update_user<?php echo $row["user_id"]; ?>">Update</button></td>
                                    <?php
                                    if ($row["user_id"] != 1) {
                                    ?>
                                        <td><a href="user_delete.php?del=<?php echo $row["user_id"]; ?>"><button type="submit" class="btn btn-danger">Delete</button></td>
                                        </tr>
                            <?php
                                    } else
                                        echo "<td><button class='btn btn-danger' disabled>Cannot delete</button></td></tr>";

                                    include 'user_upd.php';
                                }
                                echo "</table>";
                            } else {
                                echo " <div class='empty-state'>
                               <div class='empty-state__content'>
                               <div class='empty-state__icon'>
                               <i class='fa-regular fa-circle-user'></i>
                               </div>
                               <div class='empty-state__message'>No User data</div>
                               <div class='empty-state__help'><span class='badge badge-secondary'>Tip</span>
                               Add user by clicking Add new.
                               </div>
                               </div>
                               </div>";
                            }

                            ?>
                        </div><!-- /.login -->


                    </div><!-- /.Tab-panes -->

                    <!-- Modal-user role Insert -->
                    <div class="modal fade" id="modal_insert_role" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">User Role form: </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container p-5 my-2 border">
                                        <h2>Enter User Role here:</h2><br>
                                        <form name="role_form" action="user_role_insert.php" method="POST">

                                            <div class="form-group">
                                                <label for="role" class="form-label">Role: </label>
                                                <input type="text" class="form-control" id="role" name="role" required>
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

                    <!-- Modal-User Details Insert -->
                    <div class="modal fade" id="modal_insert_user" data-backdrop="static" data-keyboard="false" aria-labelledby="staticBackdropLabel" aria-hidden="true" style="overflow:hidden;">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">User details form: </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="container p-5 my-2 border">
                                        <h2>Enter your user details here:</h2><br>
                                        <form name="user_form" action="user_insert.php" method="POST">

                                            <div class="form-group">
                                                <label for="userrole" class="form-label">Select Role: </label>
                                                <select id="userrole" class="form-control select2bs4" name="userrole" style="width: 100%;" required>
                                                    <?php
                                                    // retrieving all roles
                                                    $result = $conn->query("select * from user_role");

                                                    while ($row = $result->fetch_assoc()) {
                                                        // displaying each role in the list
                                                        echo "<option value='$row[role_id]'>" . $row["role"] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div><br>

                                            <div class="form-group">
                                                <label for="username" class="form-label">User Name: </label>
                                                <input type="text" class="form-control" id="username" name="username" required>
                                            </div>
                                            <br>

                                            <div class="form-group">
                                                <label for="pass" class="form-label">Password: </label>
                                                <input type="text" class="form-control" id="pass" name="pass" placeholder="***Keep a Strong Password***" autocomplete="off" required>
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
        <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top" style="opacity: 60%;">
            <i class="fas fa-chevron-up"></i>
        </a>
        <!-- /.back-to-top button -->
    </div>
    <!-- ./wrapper -->

    <!-- scripts -->
    <?php include 'scripts.php'; ?>
    <!-- /.scripts -->
</body>

</html>