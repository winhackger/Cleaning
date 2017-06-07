<?php
	session_start();
	$list_info_maid = array();
	include_once '../../connect.php';
	include_once '../../lib/php/public_function.php';
	$today = revert_date(date('d-m-Y'));
	$sql = "SELECT booking_table.booking_id,booking_table.ref_booking_uid,booking_table.start_work,booking_table.work_status,user_detail.fname,user_detail.lname,user_detail.lat,user_detail.lng,user_detail.phone FROM `booking_detail` INNER JOIN booking_table on (booking_detail.booking_id=booking_table.booking_id) INNER JOIN user_detail on (booking_table.ref_booking_uid = user_detail.uid) WHERE `ref_maid` = '{$_SESSION['id']}' AND `booking_table`.`start_work`> '{$today}' AND `booking_table`.`status_id` ='true' AND `booking_table`.`work_status` ='false' ORDER BY `start_work` DESC";
	// echo $sql;
	if($res = mysqli_query($conn,$sql)) {
		while ($row = mysqli_fetch_assoc($res)) {
			// print "<pre>";
			 // print_r($row);
			// $row['items'] = get_item_maid($row['booking_id'],$conn);
			$row['start_date_full'] = date_thai($row['start_work']); 
			unset($row['start_work']);
			array_push($list_info_maid, $row);

		}
		// echo $sql;
		// echo "<pre>";
		// var_dump($list_info_maid);
		// echo "</pre>";
	}else{
		// var_dump($_SESSION);
	}
	$sql_work_all = "SELECT booking_table.booking_id,booking_table.ref_booking_uid,booking_table.start_work,booking_table.work_status,booking_table.status_id,user_detail.fname,user_detail.lname,user_detail.lat,user_detail.lng,user_detail.phone FROM `booking_detail` INNER JOIN booking_table on (booking_detail.booking_id=booking_table.booking_id) INNER JOIN user_detail on (booking_table.ref_booking_uid = user_detail.uid) WHERE `ref_maid` = '{$_SESSION['id']}' AND `booking_table`.`status_id` = 'true' AND `booking_table`.`work_status`='true' ";
	if($res = mysqli_query($conn,$sql_work_all)){
		while($data = mysqli_fetch_assoc($res)){
			$data1[] = $data;
		}
	}
	// echo "<pre>";
	// var_dump($data1);
	// echo "</pre>";
?>

<div class="col-lg-12">
	<section class="panel">
	<header class="panel-heading">Welcome</header>
		<div class="panel-body">
			<section id="unseen">
				<div class="row state-overview">
					<div class="col-lg-3 col-sm-6">
						<section class="panel">
							<div class="symbol" style="background-color: #039BE5">
								<i class="fa fa-file-text-o"></i>
							</div>
							<div class="value">
								<h1><b id="work_all"></b></h1>
								<p><b>งานทั้งหมด</b></p>
							</div>
						</section>
					</div>
					<div class="col-lg-3 col-sm-6">
						<section class="panel">
							<div class="symbol" style="background-color: #00C853">
								<i class="fa fa-check-circle"></i>
							</div>
							<div class="value">
								<h1><b id="work_ok"></b></h1>
								<p><b>งานที่ทำไปแล้ว</b></p>
							</div>
						</section>
					</div>
					<div class="col-lg-3 col-sm-6">
						<section class="panel">
							<div class="symbol" style="background-color: #FF3D00">
								<i class="fa fa-times-circle"></i>
							</div>
							<div class="value">
								<h1><b id="work_no"></b></h1>
								<p><b>งานที่ยังไม่ทำ</b></p>
							</div>
						</section>
					</div>
					<div class="col-lg-3 col-sm-6">
						<section class="panel">
							<div class="symbol" style="background-color: #1DE9B6">
								<i class="fa fa-thumbs-o-up"></i>
							</div>
							<div class="value">
								<h1><b id="like"></b></h1>
								<p><b>พึงพอใจ</b></p>
							</div>
						</section>
					</div>
				</div>
			</section>
			<section>
			<h1>งานที่ใกล้จะถึง</h1>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>วันที่</th>
							<th>location</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($list_info_maid as $key => $list) {
					?>
						<tr>
							<td><?=$list['start_date_full']?></td>
							<td>
								<form action="map.php" method="post" target="_blank">
									<input type="hidden" name="lat" value="<?=$list['lat'] ?>">
									<input type="hidden" name="lng" value="<?=$list['lng'] ?>">
									<button type="submit" class="btn btn-xs btn-danger">Click</button>
								</form>
							</td>

						</tr>
					<?php
					} ?>

					</tbody>
				</table>
			</section>
		</div>
	</section>
</div>
<script type="text/javascript">
	$(function(){
		$("#work_all").html("50");
		$("#work_ok").html("30");
		$("#work_no").html("20");
		$("#like").html("5");
		$("#dashboard").attr('class', 'active');
	});
</script>