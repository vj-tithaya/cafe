<?php
include_once("connectdb.php");
include_once("checklogin.php");
$sql1 = "SELECT * FROM product WHERE p_id='{$_GET['pid']}' " ;
$rs1 = mysqli_query($conn, $sql1);
$data1 = mysqli_fetch_array($rs1);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cafe A-plus</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: url('https://img.wongnai.com/p/624x0/2016/12/29/bb67e647b5a94acc963bbf4f3d49f2bd.jpg') no-repeat center center fixed; /* เพิ่มรูปพื้นหลัง */
            background-size: cover; /* ปรับขนาดให้เต็มพื้นที่ */
            font-family: Arial, sans-serif;
        }
        .container {
            background-color: rgba(255, 255, 255, 0.8); /* ทำให้กรอบมีความโปร่งแสง */
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h1 {
            text-align: center;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"], textarea, select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #2196F3;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #1976D2;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Cafe A-plus - แก้ไขสินค้า</h1>

    <form method="post" action="" enctype="multipart/form-data">
        <label for="pname">ชื่อสินค้า</label>
        <input type="text" name="pname" required autofocus value="<?=$data1['p_name'];?>">

        <label for="pdetail">รายละเอียดสินค้า</label>
        <textarea name="pdetail" rows="5" cols="50"><?=$data1['p_detail'];?></textarea>

        <label for="pprice">ราคา</label>
        <input type="text" name="pprice" required value="<?=$data1['p_price'];?>">

        <label for="pimg">รูปภาพ</label>
        <input type="file" name="pimg">

        <label for="pcat">ประเภทสินค้า</label>
        <select name="pcat">
            <?php
            $sql2 = "SELECT * FROM `category` ORDER BY c_name ASC ";
            $rs2 = mysqli_query($conn, $sql2);
            while ($data2 = mysqli_fetch_array($rs2)) {
            ?>
                <option value="<?=$data2['c_id'];?>" <?=($data1['c_id']==$data2['c_id'])?"selected":"";?>><?=$data2['c_name'];?></option>
            <?php } ?>
        </select>

        <button type="submit" name="Submit">บันทึก</button>
    </form>
     <br>
    <a href="index.php" class="back-link">← กลับไปยังหน้าหลัก</a>
    <hr>

    <?php
    if (isset($_POST['Submit'])) {
        if (empty($_FILES['pimg']['name'])) {
            $sql = "UPDATE `product` SET `p_name` = '{$_POST['pname']}', `p_detail` = '{$_POST['pdetail']}', `p_price` = '{$_POST['pprice']}', `c_id` = '{$_POST['pcat']}' WHERE `product`.`p_id` = '{$_GET['pid']}';";
        } else {
            $file_name = $_FILES['pimg']['name'];
            $ext = substr($file_name, strpos($file_name, '.') + 1);
            $sql = "UPDATE `product` SET `p_name` = '{$_POST['pname']}', `p_detail` = '{$_POST['pdetail']}', `p_price` = '{$_POST['pprice']}', `c_id` = '{$_POST['pcat']}', p_ext='{$ext}' WHERE `product`.`p_id` = '{$_GET['pid']}';";
            copy($_FILES['pimg']['tmp_name'], "images/".$_GET['pid'].".".$ext);
        }
        
        mysqli_query($conn, $sql) or die ("แก้ไขข้อมูลสินค้าไม่ได้");

        echo "<script>";
        echo "alert('แก้ไขข้อมูลสินค้าสำเร็จ');";
        echo "window.location='index.php';";
        echo "</script>";
    }
    mysqli_close($conn);
    ?>
</div>

</body>
</html>
