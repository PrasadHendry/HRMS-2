<?php
// db connection file
require_once 'db_conn.php';

// fetches updated data from the form
$fullname = $_POST['fname_upd'];
$dateofbirth = $_POST['dob_upd'];
$gender = $_POST['gender_upd'];
$address = $_POST['address_upd'];
$email = $_POST['email_upd'];
$upd_id = $_POST['eid']; 

// calculating age from dates
$today = date("Y-m-d");
$diff = date_diff(date_create($dateofbirth), date_create($today));
$age = $diff->format('%y');

if($age > 60 || $age < 18)
{
    header("location:emp_details.php?c=0&e=1");
}

else
{
    // stores updated data into the database
    $res = $conn->query("UPDATE employee_information SET employee_name='$fullname', employee_dob='$dateofbirth', employee_age=TIMESTAMPDIFF(YEAR, '$dateofbirth', CURDATE()), employee_gender='$gender', employee_address='$address', employee_email='$email' WHERE employee_id='$upd_id'");

    // redirects to display employee information after closing connection
    $conn->close();
    header("location:emp_details.php?c=0");
    exit;
}
?>