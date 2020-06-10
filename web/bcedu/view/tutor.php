<? 
    /**
     * home.php
     *
     * A simple home page for these login demos.
     *
     * David J. Malan
     * malan@harvard.edu
     */
	 //suppress notices
	error_reporting(E_ALL ^ E_NOTICE);
    // enable sessions
    session_start();
	
?>
<!DOCTYPE html>
<html>
	<head>
	<title>量子教育主页</title>
	<meta name="description" content="马上注册，丰富详实的简历和详细规范的需求能增加匹配合适人的成功率哦。">
	<meta name="keywords" content="学习，兼职">
<?php 
include(V.'header-content.php');
?>
	</head>
	<body>
<?php 
//导航条
include(V.'top-bar.php');
?>
		<?php if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"] === true) { ?>
		<div class="alert alert-success" role="alert">
			你已成功登录~         
			<a href="?page=logout"><strong>【退出】</strong><span class="glyphicon glyphicon-log-out"></span></a>
		</div>
		<!--查询我的信息-->
		<?php
		include(M."queryme.php");
		?>
		<div class="container">
			<h2>你好!<a href="?page=myinfo"><?php echo $name; ?></a><h2>
		</div>
		<?php } else { ?>
		<div class="alert alert-warning" role="alert">
			你还没有登录哦。<a href="?page=login"><strong>【登录】</strong><span class="glyphicon glyphicon-log-in"></span></a>
			<a href="?page=register"><span class="pull-right glyphicon glyphicon-edit"></span><strong class="pull-right">【注册】</strong></a>
		</div>
		<?php }?>



<?php 
//学员订单列表
include(V.'panel-student.php');
//页尾
include(V.'footer-content.php');
?>
	</body>
</html>