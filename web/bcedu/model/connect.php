<?php
	 //suppress notices
	error_reporting(E_ALL ^ E_NOTICE);
    // enable sessions
    session_start();

	//echo "<form role=\"form\" action=\"?page=connect\" method=\"post\" name=\"myform\">
					//<input name=\"connect\" type=\"hidden\"";
		//if(isset($user)) echo "value=\"$user\">";

		//echo "<input name=\"id\" type=\"hidden\" value=\"$id\">";

//<a href='javascript:document.myform.submit();'> </a>


	// connect to database
	$conn=new mysqli("localhost", "root", "rootroot","test");
	$conn->query("set names utf8");
	if($conn->connect_errno)
	{
		die('Failed to connect to the database:'.mysqli_connect_error());
	}
    //判断是否登录，不登录值为空
	if(isset($_SESSION["user"])&&!empty($_SESSION["user"]))
	{	
		$connect =mysqli_real_escape_string($conn,$_SESSION["user"]);
		$id =mysqli_real_escape_string($conn,$_GET["id"]);
		//判断QQ是否已经绑定，或者重复提交
		$query="select connect from connects where connect='$connect' and orderid='$id'";
		$result=$conn->query($query);
		$rows=$result->fetch_row();
		//用户名没有重复才往数据库插入数据
		if(empty($rows))
		{
			 // prepare query
			$query = "INSERT INTO connects (orderid,connect)
			 VALUES('$id','$connect')";


			if ($conn->query($query) == FALSE) {
			die('INSERT attempt failed');
			}
		}
	}
	else
	{
		$host = $_SERVER["HTTP_HOST"];
		$path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
		header("Location: http://$host$path/?page=tutor");
	}
	//	查询所预约的订单信息
	// prepare query
    $query = "SELECT * FROM orders WHERE id='$id'";
	$result=$conn->query($query);

    // iterate over results
    while ($row = mysqli_fetch_array($result))
    {
		$id=$row["ID"];
		$name=$row["name"];
		$grade=$row["grade"];
		$gender=$row["gender"];
		$name=$row["name"];
		$address=$row["address"];
		$detailed=$row["detailed"];
		$tel=$row["tel"];
		$subjects=$row["subject"];
		$timepay=$row["timepay"];
		$want=$row["want"];
		$time=$row["time"];
		$succeed=$row["succeed"];
    }

?>

<!DOCTYPE html>
<html>
	<head>
		<title>预约成功</title>
		<meta name=\"description\" content=\"预约成功。\">
		<meta name=\"keywords\" content=\"预约成功,量子教育\">
<?php
include(V.'header-content.php');
?>
	</head>
	<body>
<?php 
//导航条
include(V.'top-bar.php');
?>

		<div class="alert alert-success" role="alert">
			预约成功~ 点击预约列表查看      
			<a href="?page=tutor"><span class="pull-right glyphicon glyphicon-home"></span><strong class="pull-right">【返回】</strong></a>
		</div>

<div class="container">
	<div class="section">
		
					<div class="col-sm-4">
					  <div class="panel panel-info">
						<div class="panel-heading">
						  <h3 class="panel-title">#<?php echo $id;?></h3>
						</div>
						<div class="panel-body">

							<table class="table" style="table-layout:fixed">
							  <tr>
								<td><?php echo $name;?></td>
								<td><?php echo $grade;?></td>
								<td><?php echo $gender;?></td>
							  </tr>
							  <tr>
								<td>合肥市</td>
								<td><?php echo $address;?></td>
							  </tr>
							  <tr>
							  <td colspan="3"><strong>详细住址：</strong><?php echo $detailed;?></td>
							  </tr>
							  <tr>
								<td colspan="3"><strong>补习科目：</strong><?php echo $subjects;?></td>
							  </tr>
							  <tr>
								<td colspan="3"><strong>时间及薪酬：</strong><?php echo $timepay;?></td>
							  </tr>
							  <tr>
								<td colspan="3"><strong>要求：</strong><?php echo $want;?></td>
							  </tr>
							  <tr>
								<td colspan="3"><strong>发布时间：</strong><?php echo $time;?></td>
							  </tr>
							  <tr>
							  <!--点击查看预约列表 提交post信息-->
							  <form role="form" action="" method="post" name="myform">
							  <input name="id" type="hidden" value="<?php echo $id; ?>">
								<td><a href="javascript:document.myform.submit();"><span class="label label-primary" style=" float:right">查看预约列表</span></a></td>
							  </form>
							  </tr>
						  </table>
						</div>
					  </div>
					 </div>	
<?php if(isset($_POST["id"])&&!empty($_POST["id"]))
{
	//查看订单预约人名单
	$id=$_POST["id"];
	$query = "SELECT * FROM connects WHERE orderid='$id'";
	$result=$conn->query($query);

		echo "
					<div class=\"col-sm-4 col-sm-offset=4\">
					  <div class=\"panel panel-info\">
						<div class=\"panel-heading\">
						  <h3 class=\"panel-title\"></h3>
						</div>
						  <div class=\"panel-body\">
							<table class=\"table\" style=\"table-layout:fixed\">
		";
    // iterate over results
    while ($row = mysqli_fetch_array($result))
    {
		$connect=$row["connect"];
		$query1 = "SELECT * FROM registrants WHERE user='$connect'";
		$result1=$conn->query($query1);
		$row1 = mysqli_fetch_array($result1);
		$user=$row1["user"];
		$name=$row1["name"];
		$school=$row1["school"];
		$grade=$row1["grade"];
		echo "


							  <tr>
								<td>$name</td>
								<td>$school</td>
								<td>$grade</td>
							  </tr>
			 ";
	}
		echo "
						</table>
					  </div>
					 </div>
					</div>
		";
}
$result->free();
$conn->close();
?>

	</div>
</div>

<?php
//页尾
include(V.'footer-content.php');
?>
	</body>
</html>