<!-- This pasge is used for testing purpose only-->
<?php
include('db_conn.php');

if (isset($_POST["id"])) {
    $sql = "SELECT * FROM candidate_information WHERE candidate_id='$_POST[id]'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    echo json_encode($row);
}
?>