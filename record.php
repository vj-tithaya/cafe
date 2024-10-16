<meta charset="utf-8">
<?php
	@session_start();
	include("connectdb.php");
	
		foreach($_SESSION['sid'] as $cid) {
			$sum[$pid] = $_SESSION['sprice'][$cid] * $_SESSION['sitem'][$cid] ;
			@$total += $sum[$cid] ;
		}
	
	$sql = "insert into `orders` values('', '$total', CURRENT_TIMESTAMP, '0');" ;
	mysqli_query($conn, $sql) or die ("insert error") ;
	$id = mysqli_insert_id($conn);
	
	foreach($_SESSION['sid'] as $cid) {
		$sql2 = "insert into orders_detail values('', '$id', '".$_SESSION['sid'][$cid]."', '".$_SESSION['sitem'][$cid]."');" ;
		mysqli_query($conn, $sql2);
	}
	
echo "<meta http-equiv=\"refresh\" content=\"0;URL=clear.php\">";
?>