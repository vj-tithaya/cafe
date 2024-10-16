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
    <h1>Cafe A-plus - เพิ่มสินค้า</h1>

    <form method="post" action="" enctype="multipart/form-data">
        <label for="pname">ชื่อสินค้า</label>
        <input type="text" name="pname" required autofocus>

        <label for="pdetail">รายละเอียดสินค้า</label>
        <textarea name="pdetail" rows="5" cols="50"></textarea>

        <label for="pprice">ราคา</label>
        <input type="text" name="pprice" required>

        <label for="pimg">รูปภาพ</label>
        <input type="file" name="pimg">

        <label for="pcat">ประเภทสินค้า</label>
        <select name="pcat">
            <?php	
            include_once("connectdb.php");
            $sql2 = "SELECT * FROM `category` ORDER BY c_name ASC ";
            $rs2 = mysqli_query($conn, $sql2);
            while ($data2 = mysqli_fetch_array($rs2)) {
            ?>
                <option value="<?=$data2['c_id'];?>"><?=$data2['c_name'];?></option>
            <?php } ?>
        </select>

        <button type="submit" name="Submit">เพิ่มสินค้า</button>
    </form>
    <br>
    <a href="index.php" class="back-link">← กลับไปยังหน้าหลัก</a>
    <hr>

    <?php
    if (isset($_POST['Submit'])) {
        //var_dump($_FILES['pimg']['name']); exit;
        $file_name = $_FILES['pimg']['name'];
        $ext = substr($file_name, strpos($file_name, '.') + 1);

        $sql = "INSERT INTO `product` (`p_id`, `p_name`, `p_detail`, `p_price`, `p_ext`, `c_id`) VALUES (NULL, '{$_POST['pname']}', '{$_POST['pdetail']}', '{$_POST['pprice']}', '{$ext}', '{$_POST['pcat']}');";
        mysqli_query($conn, $sql) or die("เพิ่มข้อมูลสินค้าไม่ได้");
        $idauto = mysqli_insert_id($conn);

        copy($_FILES['pimg']['tmp_name'], "images/" . $idauto . "." . $ext);

        echo "<script>";
        echo "alert('เพิ่มข้อมูลสินค้าสำเร็จ');";
        echo "window.location='index.php';";
        echo "</script>";
    }
    mysqli_close($conn);
    ?>
</div>

</body>
</html>
