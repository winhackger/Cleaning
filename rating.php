<?php 
	session_start();
	include_once 'navbar.php';
	include_once 'connect.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>ให้คะแนน</title>
	<!-- <link rel="stylesheet" href="./css/rating.css"> -->
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<link href="font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<script src="./js/jquery-3.2.0.min.js"></script>
	<!-- <script src="./js/rating.js"></script> -->
	<script src="./js/bootstrap.min.js"></script>

</head>
<body>
<div class="container" style="padding-top: 60px;">
	<div class="row">
		<h1 align="center">ระดับความพึงพอใจและความคิดเห็น</h1>
	</div>
	<div class="row">
	<?php 
		$sql ="SELECT user_backend.id, user_backend.fname, user_backend.lname, user_backend.avatar FROM `booking_table`INNER JOIN `booking_detail` ON booking_table.booking_id = booking_detail.booking_id INNER JOIN `user_backend`ON booking_detail.ref_maid = user_backend.id WHERE booking_table.booking_id='{$_GET['bin']}' AND ref_booking_uid='{$_SESSION['uid']}' ";
		// echo $sql;
		if ($res = mysqli_query($conn,$sql)) {
			// var_dump($res);
			if ($res->num_rows > 0) {
				while ($row = mysqli_fetch_assoc($res)) {

	?>
		<div class="col-sm-6 col-md-4">
			<div class="thumbnail" maid-id="<?=$row['id']?>">
				<img src="backend/img/avatar_profile/<?=$row['avatar']?>" style="width: 200px;height: 200px;" alt="...">
				<div class="caption">
				<h3 align="center"><?=$row['fname']?> <?=$row['lname']?></h3>
				<p>
				<?php 
					$sql1 = "SELECT * FROM `comment_point` WHERE `maid_id`='{$row['id']}' AND `bin`='{$_GET['bin']}'";
					if ($res1 = mysqli_query($conn,$sql1)) {
						if ($res1->num_rows > 0) {
							echo "<h4 style='color:green' align='center'>ให้คะแนนและแสดงความคิดเห็นแล้ว</h4>";
						} else {
							// echo "button true";
							?>
					<a href="rating-private.php?maid=<?=$row['id']?>&bin=<?=$_GET['bin']?>" class="btn btn-primary center-block">แสดงความคิดเห็นและให้คะแนน</a>
						<?php
						}
					} else {
						echo "SQL1 ERROR";
					}
				?>
				</p>
				</div>
			</div>
		</div>
	<?php 
				}
		} else {
			echo "เลขที่บิลไม่ถูกต้อง";
		}
	} else {
		echo "SQL ERROR";
	}
	?>
	</div>
</div>
</script>
</body>
</html>