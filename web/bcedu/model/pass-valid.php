<?php
	// connect to database
	$conn=new mysqli("localhost", "root", "rootroot","test");
	$conn->query("set names utf8");
	if($conn->connect_errno)
	{
		die('Failed to connect to the database:'.mysqli_connect_error());
	}

	if(isset($_COOKIE["user"]) && isset($_COOKIE["pass"]))
	{
		$user=$_COOKIE["user"];
		$pass=$_COOKIE["pass"];
		$query="select user from registrants where user='$user' and pass='$pass'";
		$result=$conn->query($query);
		$check1=$result->fetch_row();
	}
	else if (isset($_POST["user"]) && isset($_POST["pass"]))
	{
		$user=$_POST["user"];
		$pass=$_POST["pass"];
		$query="select user from registrants where user='$user' and pass='$pass'";
		$result=$conn->query($query);
		$check2=$result->fetch_row();
	}
?>