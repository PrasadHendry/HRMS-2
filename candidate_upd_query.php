<?php
// db connection file
require_once 'db_conn.php';

// fetches updated data from the form
$fullname = $_POST['fname_upd'];
$dateofbirth = $_POST['dob_upd'];
$age = $_POST['age_upd'];
$gender = $_POST['gender_upd'];
$address = $_POST['address_upd'];
$phnumber = $_POST['phnum_upd'];
$email = $_POST['email_upd'];
$workexperience = $_POST['workexp_upd'];
$qualif = $_POST['qualif_upd'];
$upd_id = $_POST['cid'];

// stores updated data into the database
$res = $conn->query("UPDATE candidate_information SET candidate_fullname='$fullname', candidate_dob='$dateofbirth', candidate_age='$age', candidate_gender='$gender', candidate_address='$address', phnum='$phnumber', candidate_email='$email', experience_in_years='$workexperience' WHERE candidate_id='$upd_id'");

$res = $conn->query("UPDATE candidate_qualifications SET qualifications_file_location='$qualif' WHERE candidate_id='$upd_id'");

// redirects to display candidate information after closing connection
$conn->close();
header("location:candidate_details.php");
exit;
?>