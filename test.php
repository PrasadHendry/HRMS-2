<?php
include('db_conn.php');

if (isset($_POST["cand_id"])) {
    $sql = "SELECT * FROM candidate_information WHERE candidate_id='$_POST[cand_id]'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    echo json_encode($row);
}
?>
