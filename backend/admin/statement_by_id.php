<?php
	// if (condition) {
	// 	# code...
	// }
// var_dump($_POST);
	if ($_POST['maid_id'] !="") {
		$count = strlen($_POST['maid_id']);
		// var_dump($count);
		if ($count == 6) {
			include_once '../../connect.php';
			include_once '../../lib/php/public_function.php';
			$sql_salary = "SELECT * FROM `salary` WHERE `ref_maid_id`='{$_POST['maid_id']}'";
			if ($res =mysqli_query($conn,$sql_salary)) {
				if ($res->num_rows > 0) {
					?>
					<!-- <form class="form-inline" id="BeTweenStatement" action="statement_all_PDF.php?maid_id=<?=$_POST['maid_id']?>&startDate={{sDate}}&endDate={{eDate}}" method="post" target="_blank"> -->
					<form class="form-inline" id="BeTweenStatement" action="statement_all_PDF.php" method="post" target="_blank">
					<div class="form-group">
					<label>ตั้งแต่วันที่ : </label>
					<input type="date" class="form-control" name="startDate" id="startDate">
					</div>
					<div class="form-group">
					<label>ถึงวันที่ : </label>
					<input type="date" class="form-control" name="endDate" id="endDate">
					<input type="hidden" class="form-control" name="maid_id" value="<?=$_POST['maid_id']?>">
					</div>
					<button type="submit" class="btn btn-info"><i class="fa fa-print"> พิมพ์</i></button>
					</form>
					<table class="table table-bordered table-striped table-condensed" id="state">
						<thead>
							<tr>
								<th>ลำดับ</th>
								<th class="numeric">เงินเดือน</th>
								<th class="numeric">หักภาษี 7%</th>
								<th class="numeric">เงินรับสุทธิ</th>
								<th class="numeric">ตั้งแต่วันที่</th>
								<th class="numeric">ถึงวันที่</th>
								<th class="numeric">วันที่ตัด</th>
								<th class="numeric">พิมพ์</th>
							</tr>
						</thead>
						<tbody>
						<?php
						$i = 0;
							while ($row = mysqli_fetch_assoc($res)) {
							$i++;
						?>
							<tr>
								<td><?=$i?></td>
								<td class="numeric"><?=number_format($row['salary'])?></td>
								<td class="numeric"><?=number_format($row['vat'])?></td>
								<td class="numeric"><?=number_format($sum = $row['salary']-$row['vat'])?></td>
								<td class="numeric"><?=date_thai($row['startMonth'])?></td>
								<td class="numeric"><?=date_thai($row['endMonth'])?></td>
								<td class="numeric"><?=date_thai(revert_date($row['created_at']))?></td>
								<!-- <td class="numeric"><a href="statement_by_id_PDF.php?maid_id=<?=$_POST['maid_id']?>&salary_id=<?=$row['salary_id']?>" target="_blank" class="btn btn-danger btn-xs"><i class="fa fa-print"></i></a></td> -->
								<td class="numeric"><form action="statement_by_id_PDF.php" method="post" target="_blank"><input type="hidden" name="maid_id" value="<?=$_POST['maid_id']?>"><input type="hidden" name="salary_id" value="<?=$row['salary_id']?>"><button type="submit" class="btn btn-danger btn-xs"><i class="fa fa-print"></i></button></form></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
					<script type="text/javascript">

					$(function(){
						$("#startDate , #endDate").attr('required','');
					});
					</script>
						<?php
					}
				} else {
					echo "<h4 style='color:red'>กรุณาเลือกข้อมูล</h4>";
				}
		} else {
			echo "<h4 style='color:red'>กรุณาเลือกข้อมูล</h4>";
		}
	} else{
		echo "<h4 style='color:red'>กรุณาเลือกข้อมูล</h4>";
	}
?>