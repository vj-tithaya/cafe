<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>แก้ไขประเภทสินค้า</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 80%; margin: 0 auto; padding: 20px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; border: 1px solid #ddd; }
        th { background-color: #f2f2f2; }
        label { display: block; margin-bottom: 5px; }
        input { width: 100%; padding: 10px; }
        button { padding: 10px 15px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background-color: #45a049; }
        .back-link { display: block; margin-top: 20px; text-align: center; }
    </style>
</head>
<body>
<div class="container">
    <h1>แก้ไขประเภทสินค้า</h1>

    <?php
    include("connectdb.php");

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $sql = "SELECT * FROM category WHERE c_id = $id";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $category = mysqli_fetch_assoc($result);
            ?>

            <form action="edit_category.php?id=<?php echo $id; ?>" method="POST">
                <table>
                    <tr>
                        <th>ชื่อประเภทสินค้า:</th>
                        <td>
                            <input type="text" name="c_name" value="<?php echo htmlspecialchars($category['c_name']); ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: center;">
                            <button type="submit">แก้ไข</button>
                        </td>
                    </tr>
                </table>
            </form>

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $c_name = mysqli_real_escape_string($conn, $_POST['c_name']);
                
                // ใช้ Prepared Statements
                $stmt = $conn->prepare("UPDATE category SET c_name = ? WHERE c_id = ?");
                $stmt->bind_param("si", $c_name, $id);
                
                if ($stmt->execute()) {
                    echo "<p style='color: green; text-align: center;'>แก้ไขประเภทสินค้าเรียบร้อยแล้ว!</p>";
                } else {
                    echo "<p style='color: red; text-align: center;'>เกิดข้อผิดพลาด: " . $stmt->error . "</p>";
                }
                $stmt->close();
            }
        } else {
            echo '<p style="color: red; text-align: center;">ไม่พบประเภทสินค้าที่มี ID นี้</p>';
        }
    } else {
        echo '<p style="color: red; text-align: center;">ไม่พบข้อมูลประเภทสินค้า</p>';
    }

    mysqli_close($conn);
    ?>
    <a href="product_type.php" class="back-link">← กลับไปยังรายการประเภทสินค้า</a>
</div>
</body>
</html>
