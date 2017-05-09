<?php 
	session_start();
	include_once 'navbar.php';
	include_once 'connect.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>ให้คะแนน</title>
	<link rel="stylesheet" href="./css/rating.css">
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<link href="font-awesome-4.7.0/css/font-awesome.min.css" rel="stylesheet">
	<script src="./js/jquery-3.2.0.min.js"></script>
	<script src="./js/rating.js"></script>
	<script src="./js/bootstrap.min.js"></script>

</head>
<body>
<div class="container" style="padding-top: 60px;">
	<div class="row">
	<?php 
		$sql ="SELECT user_backend.id, user_backend.fname, user_backend.lname, user_backend.avatar FROM `booking_table`INNER JOIN `booking_detail` ON booking_table.booking_id = booking_detail.booking_id INNER JOIN `user_backend`ON booking_detail.ref_maid = user_backend.id WHERE booking_table.booking_id='{$_GET['bin']}' AND ref_booking_uid='{$_SESSION['uid']}' ";
		// echo $sql;
		if ($res = mysqli_query($conn,$sql)) {
			while ($row =mysqli_fetch_assoc($res)) {
				
	?>
		<div class="col-sm-6 col-md-4">
			<div class="thumbnail" maid-id="<?=$row['id']?>">
				<img src="backend/img/avatar_profile/<?=$row['avatar']?>" alt="...">
				<div class="caption">
				<h3><?=$row['fname']?> <?=$row['lname']?></h3>
				<p class="star-rating" maid-id="<?=$row['id']?>">
				    <input type="radio" class="rating" value="1" />
				    <input type="radio" class="rating" value="2" />
				    <input type="radio" class="rating" value="3" />
				    <input type="radio" class="rating" value="4" />
				    <input type="radio" class="rating" value="5" />
				</p>
				<p>
				<span>แสดงความคิดเห็น :</span>
					<textarea class="form-control" name="comment" rows="5"></textarea>
				</p>
				<p>
				<a class="btn btn-primary btn-submit" role="button">ส่ง</a> <a href="#" class="btn btn-default" role="button">Button</a>
				</p>
				</div>
			</div>
		</div>
	<?php 
			}
		} else {
			echo "error";
		}
	?>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function() {
		var uid = "<?=$_SESSION['uid']?>";

		$('.star-rating').rating(function(vote, event){
		$(".btn-submit").click(function(event) {
		console.log(vote);

			
		});
		//     $.post('star-rating.php', {vote: vote, uid: uid,maid_id: maid_id}, function() {
		//     	/*optional stuff to do after success */
		//     }).done(function(data){
		//     	alert(data);
		//     });
		});
	});

</script>
</body>
</html>