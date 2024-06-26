<?php
// db connection file
include 'db_conn.php';

// fetches updated data from the form
$emp_id = $_POST['emp_id'];
$desig_id = $_POST['desig_upd'];

// fetches current date
$start_date = new DateTime();
$start_date = $start_date->format('Y-m-d');

// stores updated data into the database
$res = $conn->query("UPDATE employee_information SET designation_id='$desig_id' WHERE employee_id='$emp_id'");

// retrieves designation information
$row = $conn->query("select base_salary from designations WHERE designation_id='$desig_id'");
$row = $row->fetch_assoc();

// updates employee's salary to the new designation
$res = $conn->query("UPDATE emp_personal_sal SET salary_amount_rec='$row[base_salary]' WHERE employee_id='$emp_id'");

// updates job history record of employee
$res = $conn->query("insert into job_history (employee_id, designation_id, job_start_date) values ('$emp_id', '$desig_id', '$start_date')");

// redirects to display employee information after closing connection
$conn->close();
header("location:emp_details.php?c=3");
exit;
?>