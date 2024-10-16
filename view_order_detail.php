<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>รายละเอียดคำสั่งซื้อ</title>
    <style>
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
    </style>
</head>

<body>
<div class="container">
    <h1>รายการสั่งซื้อ</h1>
    <a href="index.php" class="back-link">← กลับไปยังหน้าหลัก</a>
    
    <?php
    include("connectdb.php");

    // ตรวจสอบว่ามีการส่งค่า 'a' มาผ่าน GET หรือไม่
    if (isset($_GET['a'])) {
        $order_id = intval($_GET['a']); // แปลงเป็นจำนวนเต็มเพื่อความปลอดภัย

        // ดึงข้อมูลคำสั่งซื้อหลัก
        $sql_order = "SELECT * FROM orders WHERE id = $order_id";
        $result_order = mysqli_query($conn, $sql_order);

        if (mysqli_num_rows($result_order) == 1) {
            $order = mysqli_fetch_assoc($result_order);
            ?>
            <h2>ข้อมูลคำสั่งซื้อ</h2>
            <table>
                <tr>
                    <th>เลขที่คำสั่งซื้อ</th>
                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                </tr>
                <tr>
                    <th>ลูกค้า</th>
                    <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
                </tr>
                <tr>
                    <th>หมายเลขโต๊ะ</th>
                    <td><?php echo htmlspecialchars($order['table_number']); ?></td>
                </tr>
                <tr>
                    <th>ราคารวม</th>
                    <td><?php echo number_format($order['total'], 2); ?> บาท</td>
                </tr>
                <tr>
                    <th>วันเวลาสั่งซื้อ</th>
                    <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                </tr>
            </table>

            <h2>รายละเอียดคำสั่งซื้อ</h2>
            <table>
                <tr>
                    <th>ลำดับ</th>
                    <th>ชื่อสินค้า</th>
                    <th>จำนวน</th>
                    <th>ราคา/หน่วย</th>
                    <th>ราคารวม</th>
                </tr>
                <?php
                // ดึงรายการสินค้าที่สั่งซื้อ
                $sql_items = "SELECT * FROM order_item WHERE order_id = $order_id";
                $result_items = mysqli_query($conn, $sql_items);

                if (mysqli_num_rows($result_items) > 0) {
                    $no = 1;
                    while ($item = mysqli_fetch_assoc($result_items)) {
                        $total_price = $item['quantity'] * $item['price'];
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . htmlspecialchars($item['product_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($item['quantity']) . "</td>";
                        echo "<td>" . number_format($item['price'], 2) . " บาท</td>";
                        echo "<td>" . number_format($total_price, 2) . " บาท</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>ไม่มีรายการสินค้าในคำสั่งซื้อนี้</td></tr>";
                }
                ?>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>รวมทั้งสิ้น</td>
                    <td><?php echo number_format($order['total'], 2); ?> บาท</td>
                </tr>
            </table>
            <?php
        } else {
            echo "<p>ไม่พบคำสั่งซื้อที่เลือก กรุณาตรวจสอบใหม่อีกครั้ง</p>";
        }
    } else {
        echo "<p>ไม่มีการระบุเลขที่คำสั่งซื้อ</p>";
    }

    mysqli_close($conn);
    ?>
</div>

</body>
</html>
