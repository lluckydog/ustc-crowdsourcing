<?php
		// connect to database
	$conn=new mysqli("localhost", "root", "","test");
	$conn->query("set names utf8");
	if($conn->connect_errno)
	{
		die('Failed to connect to the database:'.mysqli_connect_error());
	}
	if (isset($_SESSION["user"]))
		$user=$_SESSION["user"];
	else
		$user=$_POST["user"];

		$pass =mysqli_real_escape_string($conn,$_POST["pass"]);
		$name =mysqli_real_escape_string($conn,$_POST["name"]);
		$gender = mysqli_real_escape_string($conn,$_POST["gender"]);
		$school = mysqli_real_escape_string($conn,$_POST["school"]);
		$grade = mysqli_real_escape_string($conn,$_POST["grade"]);
		$major = mysqli_real_escape_string($conn,$_POST["major"]);
		if(!empty($_POST["subject"]))
		{
			$array=$_POST["subject"];
			$subject=implode(',',$array);
		}
		else
			$subject="";
		$aboutme = mysql_real_escape_string($_POST["aboutme"]);      
		$push = $_POST["push"];

    // prepare query
	if(empty($pass))
	{
		$query = "UPDATE registrants SET name='$name',gender='$gender',school='$school',grade='$grade',
		major='$major',subject='$subject',aboutme='$aboutme',push='$push' WHERE user='$user'";
	}
	else
	{
		$query = "UPDATE registrants SET pass='$pass',name='$name',gender='$gender',school='$school',grade='$grade',
		major='$major',subject='$subject',aboutme='$aboutme',push='$push' WHERE user='$user'";
	}
	$result=$conn->query($query);
	$conn->close();

	$host = $_SERVER["HTTP_HOST"];
    $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    header("Location: http://$host$path/?page=myinfo");
?>