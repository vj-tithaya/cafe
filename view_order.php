<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>รายการคำสั่งซื้อ</title>
</head>

<body>
<h1>รายการคำสั่งซื้อ</h1>
<table width="832" border="1" cellspacing="1" cellpadding="1">
  <tr>
    <td width="153">&nbsp;</td>
    <td width="153" style="text-align: center;">เลขที่คำสั่งซื้อ</td>
    <td width="193" style="text-align: center;">ลูกค้า</td>
    <td width="150" style="text-align: center;">หมายเลขโต๊ะ</td>
    <td width="155" style="text-align: center;">ราคารวม</td>
    <td width="155" style="text-align: center;">วันเวลาสั่งซื้อ</td>
  </tr>
  
  <?php
	include("connectdb.php");
	$sql = "select  *  from  `orders`  order by id  desc ";
	$rs = mysqli_query($conn, $sql) ;
	while ($data = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
?>

  <tr>
    <td style="text-align: center;"><a href="view_order_detail.php?a=<?=$data['id'];?>">ดูรายละเอียด</a></td>
    <td style="text-align: center;"><?=$data['id'];?></td>
    <td style="text-align: center;"><?=$data['customer_name'];?></td>
    <td style="text-align: center;"><?=$data['table_number'];?></td>
    <td style="text-align: center;"><?=$data['total'];?></td>
    <td style="text-align: center;"><?=$data['order_date'];?></td>
</tr>

<?php } ?>
</table>

<!-- เพิ่ม margin-top ให้กับปุ่มเพื่อไม่ให้ติดกับตาราง -->
<a href="index.php" style="margin-top: 20px; padding: 10px; background-color: #2196F3; color: white; text-decoration: none; border-radius: 5px; display: inline-block;">กลับไปที่หน้าหลัก</a>

</body>
</html>