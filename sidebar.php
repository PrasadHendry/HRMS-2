<?php
// db connection file
include 'db_conn.php';
?>
<!-- Main Sidebar Container -->
<aside class="main-sidebar main-sidebar-custom sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index.php" class="brand-link">
    <img src="dist/img/cosmic.png" alt="Cosmic Solutions Logo" class="brand-image">
    <span class="brand-text font-weight-light"> HRSP </span>
  </a>
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="info">

        <a href="index.php" class="d-block"><i class="fa-regular fa-circle-user"></i>&nbsp;
          <?php
          // displaying user role and user name
          $row = $conn->query("select user_details.username, user_role.role from user_details inner join user_role on user_details.role_id=user_role.role_id where user_id='$_SESSION[id]'");
          $row = $row->fetch_assoc();
          echo $row["role"] . " - " . $row["username"];
          ?>
        </a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search tabs" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item menu-open">
          <a href="index.php" class="nav-link">
            <i class="nav-icon fas fa-suitcase"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="candidate_details.php" class="nav-link">
            <i class="nav-icon far fa-list-alt"></i>
            <p data-toggle="tooltip" title="Pending Candidates">
              Candidate Details
              <span class="badge badge-warning right">
                <?php
                // fetching candidate data from db
                $res = $conn->query("SELECT count(candidate_id) FROM candidate_information where employee_id is null");
                $res = $res->fetch_assoc();
                echo $res["count(candidate_id)"];
                ?>
              </span>
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="emp_details.php?c=0" class="nav-link">
            <i class="nav-icon fas fa-list-alt"></i>
            <p>
              Employee Details
              <?php
              $res = $conn->query("select count(*) from employee_information where designation_id is null");
              $res = $res->fetch_assoc();

              if ($res["count(*)"] == 0) {
                echo "<span data-toggle='tooltip' data-placement='right' title='Total Employees' class='badge badge-info right'>";

                // fetching employee data from db
                $res = $conn->query("SELECT count(employee_id) FROM employee_information");
                $res = $res->fetch_assoc();
                echo $res["count(employee_id)"];

                echo "</span>";
              } else
                echo "<span data-toggle='tooltip' data-placement='right' title='△ Set Designations △' class='badge badge-danger right'><i class='fa-solid fa-triangle-exclamation'></i></span>";
              ?>
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="user_reg_view.php?c=0" class="nav-link">
            <i class="nav-icon far fa-list-alt"></i>
            <p data-toggle="tooltip" title="Users">
              User Registrations
              <span class="badge badge-info right">
                <?php
                // fetching user data from db
                $res = $conn->query("SELECT count(user_id) FROM user_details");
                $res = $res->fetch_assoc();
                echo $res["count(user_id)"];
                ?>
              </span>
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="cmp_struct_view.php" class="nav-link">
            <i class="nav-icon far fa-building"></i>
            <p>
              Company Structure
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="cmp_struct_view.php?c=0" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Departments</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="cmp_struct_view.php?c=1" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Designations</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="history_rec_view.php" class="nav-link">
            <i class="nav-icon fas fa-history"></i>
            <p>
              History Records
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="history_rec_view.php?c=0" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Job History</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="history_rec_view.php?c=1" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Disciplinary History</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="history_rec_view.php?c=2" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Salary History</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="history_rec_view.php?c=3" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Overtime Pay History</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="finance_rec_view.php" class="nav-link">
            <i class="nav-icon fas fa-money-check"></i>
            <p>
              Financial Records
              <i class="right fas fa-angle-left"></i>
              <?php
              // fetches number of uncleared employee salary records
              $res = $conn->query("select count(salary_id) from employee_salary where clearance = 'pending'");
              $res = $res->fetch_assoc();
              // fetches number of uncleared employee overtime pay records
              $res_otp = $conn->query("select count(otp_pay_id) from overtime_pay_emp where clearance = 'pending'");
              $res_otp = $res_otp->fetch_assoc();

              if ($res["count(salary_id)"] != 0 || $res_otp["count(otp_pay_id)"] != 0) {
                echo "<span data-toggle='tooltip' data-placement='right' title='△ Due Amount to be cleared △' class='badge badge-warning right'><i class='fa-solid fa-triangle-exclamation'></i></span>";
              }
              ?>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="finance_rec_view.php?c=0" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Salary Payments</p>
                <?php
                // badge displays number of salary records pending if any
                if ($res["count(salary_id)"] != 0) {
                  echo "<span class='badge badge-warning right'>";
                  echo $res["count(salary_id)"];
                  echo "</span>";
                }
                ?>
              </a>
            </li>
            <li class="nav-item">
              <a href="finance_rec_view.php?c=1" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Overtime Payments</p>
                <?php
                // badge displays number of overtime pay records pending if any
                if ($res_otp["count(otp_pay_id)"] != 0) {
                  echo "<span class='badge badge-warning right'>";
                  echo $res_otp["count(otp_pay_id)"];
                  echo "</span>";
                }
                ?>
              </a>
            </li>
            <li class="nav-item">
              <a href="finance_rec_view.php?c=2" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Compensation</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="finance_rec_view.php" class="nav-link">
            <i class="nav-icon fas fa-clock"></i>
            <p>
              Time and Attendance
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="time_rec_view.php?c=0" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Attendance</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="time_rec_view.php?c=1" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Attendance records</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="time_rec_view.php?c=2" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Leave Types</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="time_rec_view.php?c=3" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Leave management</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="time_rec_view.php?c=4" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Leave Records</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <div class="sidebar-custom">
    <a href="manual/HRSP_USER_MANUAL.pdf" class="btn btn-info btn-lg btn-block"><i class="fa-solid fa-circle-question"></i>&nbsp; User Manual</a>
  </div>
  <!-- /.sidebar-custom -->
  </aside>