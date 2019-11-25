<?php 
//database_connection.php

$connect = new PDO("mysql:host=localhost; dbname=student_attendance","root","");

$base_url = "https://localhost/student_attendance_system/";


function get_total_records($connect, $table_name)
{
	$query = "SELECT * FROM $table_name";
	$statement = $connect->prepare($query);
	$statement->execute();
}
?>