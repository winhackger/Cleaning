<?php
	session_start();
	// var_dump($_POST);
	// var_dump($_SESSION);
	include_once '../../connect.php';
	if ($_POST['event'] == "send") {
		$sql = "INSERT INTO `borrow_table`(`ref_maid_id`) VALUES ('{$_SESSION['id']}') ";
		if (mysqli_query($conn, $sql)) {
			foreach ($_SESSION['items_cart'] as $item_id => $amount) {
				$sql1 ="INSERT INTO `borrow_detail`(`ref_borrow_id`, `item_id`, `item_amount`) VALUES ('{$_SESSION['id']}','{$item_id}','{$amount}') ";
				if (mysqli_query($conn, $sql1)) {
					$_SESSION['items_cart'] = array();
					echo "true";
				}
			}
		}
	} else {
		echo "ERROR SEND";
	}
?>