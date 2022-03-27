<?php
include('db_conn.php');

if (isset($_POST["cand_id"])) {
    $sql = "SELECT candidate_information.candidate_id, candidate_information.candidate_fullname as candidate_fullname, candidate_information.candidate_dob as candidate_dob, candidate_information.candidate_age as candidate_age, candidate_information.candidate_gender as candidate_gender, candidate_information.candidate_address as candidate_address, candidate_information.phnum as phnum, candidate_information.candidate_email as candidate_email, candidate_information.experience_in_years as experience_in_years, candidate_qualifications.qualifications_file_location as qualifications_file_location FROM candidate_information INNER JOIN candidate_qualifications ON candidate_information.candidate_id=candidate_qualifications.candidate_id WHERE candidate_information.candidate_id='$_POST[cand_id]'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    echo json_encode($row);
}
?>
