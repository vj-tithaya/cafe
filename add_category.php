<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>เพิ่มประเภทสินค้า</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 90%; margin: 0 auto; }
        h1 { text-align: center; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px auto;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
        }
        button {
            padding: 10px 15px;
            background-color: #4CAF50; /* สีเขียว */
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            opacity: 0.8; /* เปลี่ยนความโปร่งใสเมื่อเอาเมาส์ไปวาง */
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>เพิ่มประเภทสินค้า</h1>
    <form action="add_category.php" method="POST">
        <table>
            <tr>
                <th>ชื่อประเภทสินค้า:</th>
                <td>
                    <input type="text" name="c_name" required>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <button type="submit">เพิ่ม</button>
                </td>
            </tr>
        </table>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include("connectdb.php");

        $c_name = mysqli_real_escape_string($conn, $_POST['c_name']);

        $sql = "INSERT INTO category (c_name) VALUES ('$c_name')";
        if (mysqli_query($conn, $sql)) {
            echo "<p style='text-align: center; color: green;'>เพิ่มประเภทสินค้าเรียบร้อยแล้ว!</p>";
        } else {
            echo "<p style='text-align: center; color: red;'>เกิดข้อผิดพลาด: " . mysqli_error($conn) . "</p>";
        }

        mysqli_close($conn);
    }
    ?>
    <a href="product_type.php" class="back-link">← กลับไปยังรายการประเภทสินค้า</a>
</div>
</body>
</html>
