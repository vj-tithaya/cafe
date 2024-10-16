<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ใบเสร็จการชำระเงิน</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f7f7f7;
    }
    .container {
        width: 80%;
        margin: 20px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .receipt {
        border: 1px solid #ddd;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
    }
    h1, h2 {
        text-align: center;
    }
    h2 {
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
    }
    th, td {
        border: 1px solid #ddd;
        padding: 10px;
        text-align: center;
    }
    th {
        background-color: #f2f2f2;
    }
    .total {
        font-size: 20px;
        font-weight: bold;
        text-align: right;
    }
    .footer {
        margin-top: 20px;
        text-align: center;
    }
</style>
</head>

<body>
<div class="container">
    <h1>ใบเสร็จการชำระเงิน</h1>
    <?php
    include("connectdb.php");

    if (isset($_GET['order_id'])) {
        $order_id = intval($_GET['order_id']);

        // ดึงข้อมูลคำสั่งซื้อ
        $sql_order = "SELECT * FROM orders WHERE id = $order_id";
        $result_order = mysqli_query($conn, $sql_order);

        if (mysqli_num_rows($result_order) == 1) {
            $order = mysqli_fetch_assoc($result_order);
            ?>
            <div class="receipt">
                <h2>รายละเอียดคำสั่งซื้อ</h2>
                <p>รหัสคำสั่งซื้อ: <strong><?php echo $order_id; ?></strong></p>
                <p>รวมทั้งสิ้น: <strong><?php echo number_format($order['total'], 2); ?> บาท</strong></p>

                <h3>รายการสินค้า</h3>
                <table>
                    <tr>
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
                        while ($item = mysqli_fetch_assoc($result_items)) {
                            $total_price = $item['quantity'] * $item['price'];
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($item['product_name']) . "</td>";
                            echo "<td>" . htmlspecialchars($item['quantity']) . "</td>";
                            echo "<td>" . number_format($item['price'], 2) . " บาท</td>";
                            echo "<td>" . number_format($total_price, 2) . " บาท</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </table>
                <p class="total">รวมทั้งสิ้น: <?php echo number_format($order['total'], 2); ?> บาท</p>
            </div>
            <div class="footer">
                <p>ขอบคุณที่ใช้บริการของเรา!</p>
                <p>วันที่: <?php echo date("Y-m-d H:i:s"); ?></p>
            </div>
	<a href="index.php" class="back-link">← กลับไปยังหน้าหลัก</a>
            <?php
        } else {
            echo "<p>ไม่พบคำสั่งซื้อที่เลือก</p>";
        }
    } else {
        echo "<p>ไม่มีการระบุเลขที่คำสั่งซื้อ</p>";
    }

    mysqli_close($conn);
    ?>
</div>
</body>
</html>
