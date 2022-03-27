<?php include('db_conn.php');

$output= array();
$sql = "SELECT candidate_id,candidate_fullname,candidate_dob,candidate_age,candidate_gender,candidate_address,phnum,candidate_email FROM candidate_information ";

$totalQuery = mysqli_query($conn,$sql);
$total_all_rows = mysqli_num_rows($totalQuery);

$columns = array(
	0 => 'candidate_id',
	1 => 'candidate_fullname',
	2 => 'candidate_dob',
	3 => 'candidate_age',
	4 => 'candidate_gender',
	5 => 'candidate_address',
	6 => 'phnum',
	7 => 'candidate_email'
);

if(isset($_POST['search']['value']))
{
	$search_value = $_POST['search']['value'];
	$sql .= " WHERE candidate_fullname like '%".$search_value."%'";
	$sql .= " OR candidate_age like '%".$search_value."%'";
	$sql .= " OR candidate_gender like '%".$search_value."%'";
	$sql .= " OR candidate_email like '%".$search_value."%'";
}

if(isset($_POST['order']))
{
	$column_name = $_POST['order'][0]['column'];
	$order = $_POST['order'][0]['dir'];
	$sql .= " ORDER BY ".$columns[$column_name]." ".$order."";
}
else
{
	$sql .= " ORDER BY candidate_id desc";
}

if($_POST['length'] != -1)
{
	$start = $_POST['start'];
	$length = $_POST['length'];
	$sql .= " LIMIT  ".$start.", ".$length;
}	

$query = mysqli_query($conn,$sql);
$count_rows = mysqli_num_rows($query);
$data = array();
while($row = mysqli_fetch_assoc($query))
{
	$sub_array = array();
	$sub_array[] = $row['candidate_id'];
	$sub_array[] = $row['candidate_fullname'];
	$sub_array[] = $row['candidate_dob'];
	$sub_array[] = $row['candidate_age'];
	$sub_array[] = $row['candidate_gender'];
	$sub_array[] = $row['candidate_address'];
	$sub_array[] = $row['phnum'];
	$sub_array[] = $row['candidate_email'];
	$sub_array[] = '<a href="javascript:void();" data-id="'.$row['candidate_id'].'"  class="btn btn-info btn-sm editbtn" >Edit</a> <a href="javascript:void();" data-id="'.$row['candidate_id'].'"  class="btn btn-success btn-sm acptbtn" >Accept</a> <a href="javascript:void();" data-id="'.$row['candidate_id'].'"  class="btn btn-danger btn-sm deleteBtn" >Delete</a>';
	$data[] = $sub_array;
}

$output = array(
	'draw'=> intval($_POST['draw']),
	'recordsTotal' =>$count_rows ,
	'recordsFiltered'=>   $total_all_rows,
	'data'=>$data,
);
echo  json_encode($output);
