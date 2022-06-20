<?php
// db connection file
include 'db_conn.php';

$fullname = $_POST['fullname'];
$dateofbirth = $_POST['dateofbirth'];
$gender = $_POST['gender'];
$address = $_POST['address'];
$phnumber = $_POST['phnumber'];
$email = $_POST['email'];
$wexp = $_POST['workexperience'];
$qualif = $_POST['qualifications'];

// calculating age from dates
$today = date("Y-m-d");
$diff = date_diff(date_create($dateOfBirth), date_create($today));
$age = $diff->format('%y');

if($age > 60 || $age < 18)
{
    header("location:candidate_details.php?e=1");
}

else
{
    // inserting candidate details
    $res = mysqli_query($conn, "INSERT INTO candidate_information (candidate_fullname, candidate_dob, candidate_age, candidate_gender, candidate_address, phnum, candidate_email, experience_in_years) values ('$fullname', '$dateofbirth', TIMESTAMPDIFF(YEAR, '$dateofbirth', CURDATE()), '$gender', '$address', '$phnumber', '$email', '$wexp')");

    // inserting qualifications of candidate
    $res = mysqli_query($conn, "INSERT INTO candidate_qualifications (candidate_id, qualifications_file_location) values ((select candidate_id from candidate_information order by candidate_id desc limit 1), '$qualif')");

    // redirects to display candidate information after closing connection
    $conn->close();
    header("location:candidate_details.php");
    exit;
}
?>