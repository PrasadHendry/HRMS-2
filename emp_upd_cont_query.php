<?php
// db connection file
require_once 'db_conn.php';

// fetches updated data from the form
$phnum_hm = $_POST['phnum_hm'];
$phnum_wk = $_POST['phnum_wk'];
$phnum_mb = $_POST['phnum_mb'];
$upd_id = $_POST['eid']; 

// stores updated data into the database
$res = $conn->query("UPDATE employee_phnum SET phnum_home='$phnum_hm', phnum_work='$phnum_wk', phnum_mobile='$phnum_mb' WHERE employee_id='$upd_id'");
$res = $conn->query("UPDATE candidate_information SET phnum='$phnum_wk' WHERE employee_id='$upd_id'");

// redirects to display employee information after closing connection
$conn->close();
header("location:emp_details.php?c=1");
exit;
?>