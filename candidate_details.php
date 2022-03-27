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

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Sidebar -->
            <?php include 'sidebar.php' ?>
            <!-- /.sidebar -->
        </aside>

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
                    <div class="row">
                        <div class="container">
                            <!-- add user button
        <div class="btnAdd">
          <a href="#!" data-id="" data-bs-toggle="modal" data-bs-target="#addUserModal" class="btn btn-success btn-sm">Add User</a>
        </div>
        -->
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-8">
                                    <table id="example" class="table">
                                        <thead>
                                            <th>Candidate Id</th>
                                            <th>Full Name</th>
                                            <th>Date of Birth</th>
                                            <th>Age</th>
                                            <th>Gender</th>
                                            <th>Address</th>
                                            <th>Contact Number</th>
                                            <th>Email</th>
                                            <th>Options</th>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-2"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal -->
                    <!-- <div class="modal fade" id="modal_insert" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
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
                    </div> -->
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
    <script src="js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/dt-1.10.25datatables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable({
                "fnCreatedRow": function(nRow, aData, iDataIndex) {
                    $(nRow).attr('candidate_id', aData[0]);
                },
                'serverSide': 'true',
                'processing': 'true',
                'paging': 'true',
                'order': [],
                'ajax': {
                    'url': 'fetch_data.php',
                    'type': 'post',
                },
                "aoColumnDefs": [{
                        "bSortable": false,
                        "aTargets": [8]
                    },

                ]
            });
        });

        /* add user js script
            $(document).on('submit', '#addUser', function(e) {
              e.preventDefault();
              var city = $('#addCityField').val();
              var username = $('#addUserField').val();
              var mobile = $('#addMobileField').val();
              var email = $('#addEmailField').val();
              if (city != '' && username != '' && mobile != '' && email != '') {
                $.ajax({
                  url: "add_user.php",
                  type: "post",
                  data: {
                    city: city,
                    username: username,
                    mobile: mobile,
                    email: email
                  },
                  success: function(data) {
                    var json = JSON.parse(data);
                    var status = json.status;
                    if (status == 'true') {
                      mytable = $('#example').DataTable();
                      mytable.draw();
                      $('#addUserModal').modal('hide');
                    } else {
                      alert('failed');
                    }
                  }
                });
              } else {
                alert('Fill all the required fields');
              }
            });
        */

        /* update user js script
            $(document).on('submit', '#updateUser', function(e) {
              e.preventDefault();
              //var tr = $(this).closest('tr');
              var city = $('#cityField').val();
              var username = $('#nameField').val();
              var mobile = $('#mobileField').val();
              var email = $('#emailField').val();
              var trid = $('#trid').val();
              var id = $('#id').val();
              if (city != '' && username != '' && mobile != '' && email != '') {
                $.ajax({
                  url: "update_user.php",
                  type: "post",
                  data: {
                    city: city,
                    username: username,
                    mobile: mobile,
                    email: email,
                    id: id
                  },
                  success: function(data) {
                    var json = JSON.parse(data);
                    var status = json.status;
                    if (status == 'true') {
                      table = $('#example').DataTable();
                      // table.cell(parseInt(trid) - 1,0).data(id);
                      // table.cell(parseInt(trid) - 1,1).data(username);
                      // table.cell(parseInt(trid) - 1,2).data(email);
                      // table.cell(parseInt(trid) - 1,3).data(mobile);
                      // table.cell(parseInt(trid) - 1,4).data(city);
                      var button = '<td><a href="javascript:void();" data-id="' + id + '" class="btn btn-info btn-sm editbtn">Edit</a>  <a href="#!"  data-id="' + id + '"  class="btn btn-danger btn-sm deleteBtn">Delete</a></td>';
                      var row = table.row("[id='" + trid + "']");
                      row.row("[id='" + trid + "']").data([id, username, email, mobile, city, button]);
                      $('#exampleModal').modal('hide');
                    } else {
                      alert('failed');
                    }
                  }
                });
              } else {
                alert('Fill all the required fields');
              }
            });
        */

        //edit button js script
        $('#example').on('click', '.editbtn ', function(event) {
            var table = $('#example').DataTable();
            var trid = $(this).closest('tr').attr('id');
            // console.log(selectedRow);
            var candidate_id = $(this).data('id');
            

            $.ajax({
                url: "test.php",
                data: {
                    cand_id: candidate_id
                },
                type: 'post',
                success: function(data) {
                    var json = JSON.parse(data);
                    $('#fname_upd').val(json.username);
                    $('#dob_upd').val(json.dob);
                    $('#gender_upd').val(json.gender);
                    $('#address_upd').val(json.addr);
                    $('#phnum_upd').val(json.mobile);
                    $('#email_upd').val(json.email);
                    $('#workexp_upd').val(json.workexp);
                    $('#qualif_upd').val(json.qualif);
                    $('#cid').val(trid);
                    $('#cand_upd').modal('show');
                },
                error: function() {
                    alert('error');
                }
            })
        });


        /* delete button js script
            $(document).on('click', '.deleteBtn', function(event) {
              var table = $('#example').DataTable();
              event.preventDefault();
              var id = $(this).data('id');
              if (confirm("Are you sure want to delete this User ? ")) {
                $.ajax({
                  url: "delete_user.php",
                  data: {
                    id: id
                  },
                  type: "post",
                  success: function(data) {
                    var json = JSON.parse(data);
                    status = json.status;
                    if (status == 'success') {
                      //table.fnDeleteRow( table.$('#' + id)[0] );
                      //$("#example tbody").find(id).remove();
                      //table.row($(this).closest("tr")) .remove();
                      $("#" + id).closest('tr').remove();
                    } else {
                      alert('Failed');
                      return;
                    }
                  }
                });
              } else {
                return null;
              }



            })
            */
    </script>
    <!-- /.scripts -->

    <!-- modal update -->
    <div class="modal fade" id="cand_upd" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Candidate Update form: </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container p-5 my-2 border">
                        <h2>Update your details here:</h2><br>
                        <form name="candidate_upd" action="candidate_upd_query.php" method="POST">

                            <div class="form-group">
                                <label for="fname_upd" class="form-label">Full Name: </label>
                                <input type="text" class="form-control" id="fname_upd" name="fname_upd" required>
                            </div>
                            <br>

                            <div class="form-inline">
                                <label for="dob_upd" class="form-label">Date of Birth: </label>
                                <div class="col-sm-2">
                                    <input type="date" class="form-control" id="dob_upd" name="dob_upd" required>
                                </div>
                            </div>
                            <br>

                            <div class="form-check">
                                <label for="gender_upd" class="form-label">Gender: </label>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="gender_upd" name="gender_upd" value="Male">Male
                                    <label class="form-check-label" for="gender_upd"></label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="gender_upd" name="gender_upd" value="Female">Female
                                    <label class="form-check-label" for="gender_upd"></label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="gender_upd" name="gender_upd" value="Others">Others
                                    <label class="form-check-label" for="gender_upd"></label>
                                </div>
                            </div>
                            <br>

                            <div class="form-group">
                                <label for="address_upd" class="form-label">Address: </label>
                                <textarea type="text" class="form-control" rows="5" cols="33" id="address_upd" name="address_upd" required></textarea>
                            </div>
                            <br>

                            <div class="form-group">
                                <label for="phnum_upd" class="form-label">Phone number: (+91) </label>
                                <input type="tel" class="form-control" id="phnum_upd" name="phnum_upd" maxlength="10" pattern="[1-9]{1}[0-9]{9}" title="Please enter a valid 10 digits contact number" required>
                            </div>
                            <br>

                            <div class="form-group">
                                <label for="email_upd" class="form-label">Email address: </label>
                                <input type="email" class="form-control" id="email_upd" name="email_upd" aria-describedby="emailHelp" required>
                                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                            </div>
                            <br>

                            <div class="form-inline">
                                <label for="workexp_upd" class="form-label">Experience (in years): </label>
                                <div class="col-sm-2">
                                    <input type="number" class="form-control" id="workexp_upd" name="workexp_upd" required>
                                </div>
                            </div>
                            <br>

                            <div class="form-group">
                                <label for="qualif_upd" class="form-label">Qualifications: </label>
                                <input type="text" class="form-control" id="qualif_upd" name="qualif_upd" required>
                            </div>
                            <br>

                            <input type="hidden" id="cid" name="cid">

                            <button type="submit" class="btn btn-primary" style="float: right;">Submit</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>