<?php
include("connectdb.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM category WHERE c_id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "<p>ลบประเภทสินค้าเรียบร้อยแล้ว!</p>";
    } else {
        echo "<p>เกิดข้อผิดพลาด: " . mysqli_error($conn) . "</p>";
    }
} else {
    echo "<p>ไม่มีการระบุ ID</p>";
}

mysqli_close($conn);
header("Location: product_type.php");
exit();
?>
