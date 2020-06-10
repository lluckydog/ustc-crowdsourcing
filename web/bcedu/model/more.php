<?php
	// connect to database
	$conn=new mysqli("localhost", "root", "","test");
	$conn->query("set names utf8");
	if($conn->connect_errno)
	{
		die('Failed to connect to the database:'.mysqli_connect_error());
	}
	
    // prepare query
    $query = "SELECT * FROM orders order by ID desc";
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

		if($succeed==0)
		echo " 
					<div class=\"col-sm-4\">
					  <div class=\"panel panel-info\">
						<div class=\"panel-heading\">
						  <h3 class=\"panel-title\">#$id</h3>
						</div>
						<div class=\"panel-body\">

							<table class=\"table\" style=\"table-layout:fixed\">
							  <tr>
								<td>$name</td>
								<td>$grade</td>
								<td>$gender</td>
							  </tr>
							  <tr>
								<td>合肥市</td>
								<td>$address</td>
							  </tr>
							  <tr>
							  <td colspan=\"3\"><strong>详细住址：</strong>$detailed</td>
							  </tr>
							  <tr>
								<td colspan=\"3\"><strong>补习科目：</strong>$subjects</td>
							  </tr>
							  <tr>
								<td colspan=\"3\"><strong>时间及薪酬：</strong>$timepay</td>
							  </tr>
							  <tr>
								<td colspan=\"3\"><strong>要求：</strong>$want</td>
							  </tr>
							  <tr>
								<td colspan=\"3\"><strong>发布时间：</strong>$time</td>
							  </tr>
							  <tr>
								<td><a href=\"?page=connect&id=$id\"><span class=\"label label-success\" style=\" float:left\">点击预约</span></a></td>
							  </tr>
						  </table>

						</div>
					  </div>
					 </div>	
		";
		else
		echo "
					<div class=\"col-sm-4\">
					  <div class=\"panel panel-info\">
						<div class=\"panel-heading\">
						  <h3 class=\"panel-title\">#$id</h3>
						</div>
						<div class=\"panel-body\">

							<table class=\"table\" style=\"table-layout:fixed\">
							  <tr>
								<td>$name</td>
								<td>$grade</td>
								<td>$gender</td>
							  </tr>
							  <tr>
								<td>合肥市</td>
								<td>$address</td>
							  </tr>
							  <tr>
							  <td colspan=\"3\"><strong>详细住址：</strong>$detailed</td>
							  </tr>
							  <tr>
								<td colspan=\"3\"><strong>补习科目：</strong>$subjects</td>
							  </tr>
							  <tr>
								<td colspan=\"3\"><strong>时间及薪酬：</strong>$timepay</td>
							  </tr>
							  <tr>
								<td colspan=\"3\"><strong>要求：</strong>$want</td>
							  </tr>
							  <tr>
								<td colspan=\"3\"><strong>发布时间：</strong>$time</td>
							  </tr>
							  <tr>
							  
								<td><span class=\"label label-warning\" style=\" float:left\">已成功</span></td>
							  </tr>
						  </table>

						</div>
					  </div>
					 </div>
		";

    }


	$result->free();
	$conn->close();
?>