<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>รายการประเภทสินค้า</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
        .container {
            width: 90%;
            margin: 0 auto;
        }
        .back-link {
            margin: 20px;
            display: block;
        }
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        .btn {
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        .btn-edit {
            background-color: #2196F3; /* สีฟ้า */
        }
        .btn-delete {
            background-color: #f44336; /* สีแดง */
        }
        .btn:hover {
            opacity: 0.8; /* เปลี่ยนความโปร่งใสเมื่อเอาเมาส์ไปวาง */
        }
    </style>
</head>
<body>
<div class="container">
    <h1>รายการประเภทสินค้า</h1>
    <a href="index.php" class="back-link">← กลับไปยังหน้าหลัก</a>
    
    <div style="text-align: center; margin: 20px 0;">
        <a href="add_category.php" class="btn btn-edit">เพิ่มประเภทสินค้า</a>
    </div>

    <?php
    include("connectdb.php");

    $sql = "SELECT * FROM category";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo '<table>';
            echo '<tr><th>ลำดับ</th><th>ชื่อประเภทสินค้า</th><th>จัดการประเภทสินค้า</th></tr>';
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . $no++ . '</td>';
                echo '<td>' . htmlspecialchars($row['c_name']) . '</td>';
                echo '<td class="action-buttons">
                        <a href="edit_category.php?id=' . $row['c_id'] . '" class="btn btn-edit">แก้ไข</a>
                        <a href="delete_category.php?id=' . $row['c_id'] . '" class="btn btn-delete" onclick="return confirm(\'คุณแน่ใจว่าต้องการลบประเภทสินค้านี้?\');">ลบ</a>
                      </td>';
                echo '</tr>';
            }
            echo '</table>';
        } else {
            echo '<p>ไม่มีประเภทสินค้าในฐานข้อมูล</p>';
        }
    } else {
        echo '<p>เกิดข้อผิดพลาดในการดึงข้อมูล: ' . mysqli_error($conn) . '</p>';
    }

    mysqli_close($conn);
    ?>
</div>
</body>
</html>
