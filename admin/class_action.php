<?php

//class_action.php

include('database_connection.php');

session_start();


$output = '';

if(isset($_POST["action"]))
{
	if($_POST["action"] == "fetch")
	{
		$query .= "SELECT * FROM class";
		if(isset($_POST["search"]["value"]))
		{
			$query .= 'WHERE class_name LIKE "%'.$_POST["search"]["value"].'%" ';
		}
		if(isset($_POST["order"]))
		{
			$query .= 'ORDER BY '.$_POST['order']['0']['column'].' '.$_POST['order']['0']['dir'].' ';
		}
		else
		{
			$query .= 'ORDER BY class_id DESC';
		}
		if($_POST["length"] != -1)
		{
			$query .= 'LIMIT' .$_POST['start'].', '.$_POST['length'];
		}
		
		$statement = $connect->prepare($query);
		$statement->execute();
		$result = $statement->fetchAll();
		$data = array();
		$filtered_rows = $statement->rowCount();
		foreach($result as $rows)
		{
			$sub_array = array();
			$sub_array[] = $row["class_name"];
			$sub_array[] = '<button type="button" name = "edit_grade" class="btn btn-primary btn-sm edit_grade" id="'.$row["class_id"].'">EDIT</button>';
			$sub_array[] = '<button type="button" name = "delete_grade" class="btn btn-primary btn-sm delete_grade" id="'.$row["class_id"].'">DELETE</button>';
			$data[] = $sub_array;
		}
			
		$output = array(
			"draw" => inval($_POST["draw"]),
			"recordsTotal" => $filtered_rows,
			"recordFiltered" => get_total_records($connect, 'class'),
			"data" => $data
		);
		
		echo json_encode($output);
		}
		
	}
}
?>