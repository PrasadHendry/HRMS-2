<?php
// db connection file
require_once 'db_conn.php';

// fetches updated data from the form
$qualif = $_POST['qualif_upd'];
$upd_id = $_POST['eid']; 

// stores updated data into the database
$res = $conn->query("UPDATE employee_qualifications SET qualifications_file_location='$qualif' WHERE employee_id='$upd_id'");
$res = $conn->query("UPDATE candidate_qualifications SET qualifications_file_location='$qualif' WHERE candidate_id=(select candidate_id from candidate_information where employee_id='$upd_id')");

// redirects to display employee information after closing connection
$conn->close();
header("location:emp_details.php?c=2");
exit;
?> 