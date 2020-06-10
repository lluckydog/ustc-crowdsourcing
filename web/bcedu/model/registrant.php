<?php

	// connect to database
	$conn=new mysqli("localhost", "root", "rootroot","test");
	$conn->query("set names utf8");
	if($conn->connect_errno)
	{
		die('Failed to connect to the database:'.mysqli_connect_error());
	}
	
    //判断是否是从注册页跳转过来的，防止恶意访问。
	if(isset($_POST["user"]))
	{
		$user =$_POST["user"];
		//判断QQ是否被注册过，或者重复提交
		$query="select user from registrants where user='$user'";
		$result=$conn->query($query);
		$rows=$result->fetch_row();
		//用户名没有重复才往数据库插入数据
		if(empty($rows))
		{
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
			$aboutme = mysqli_real_escape_string($conn,$_POST["aboutme"]);      
			$push = 1;//默认注册即发布



			// prepare query
			$query = "INSERT INTO registrants (user, pass, name, gender, school, grade, major, subject, aboutme, push)
			 VALUES('$user', '$pass', '$name', '$gender', '$school', '$grade', '$major', '$subject', '$aboutme', '$push')";

			if ($conn->query($query) == FALSE) {
			die('INSERT attempt failed');
			}

			$query="SELECT LAST_INSERT_ID()";
			$result=$conn->query($query);
			$id=$result->fetch_row();
		}
	}
	else
	{
		$host = $_SERVER["HTTP_HOST"];
		$path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
		header("Location: http://$host$path/?page=register");
	}
	$result->free();
	$conn->close();
?>